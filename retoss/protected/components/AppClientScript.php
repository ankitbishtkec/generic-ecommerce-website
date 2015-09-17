<?php
/**
 * CClientScript class file.
 *
 * @author ankit
 */

/**
 * Improved to responding with segregated non html elements ( scripts name css names) etc 
 * on demand when request is made using AJAX.
 */
class AppClientScript extends CClientScript
{
	public $enableRenderingForAjaxResponse = false;
	
	//add the core scripts name in /web/js/packages.php which should not be loaded.better used in ajax calls
	public $bannedCoreScripts = array();
	
	//add the JS files name which should not be loaded.better used in ajax calls
	public $bannedJsFiles = array();
	
	//add the css files which should not be loaded.better used in ajax calls
	public $bannedCssFiles = array();
	
	public $scriptStore = array(); 

	public function returnScriptStore()
	{
		return $this->scriptStore;
	}
	
	public function registerCoreScript($name)
	{
		if( in_array($name, $this->bannedCoreScripts))
			return $this;
		
		parent::registerCoreScript($name);
	}
	
	public function registerScriptFile($name,$position=null,array $htmlOptions=array())
	{
		if( in_array($name, $this->bannedJsFiles))
			return $this;
		
		parent::registerScriptFile($name,$position,$htmlOptions);
	}
	
	public function registerCssFile($name,$media='')
	{
		if( in_array($name, $this->bannedCssFiles))
			return $this;
		
		parent::registerCssFile($name, $media );
	}

	
	public function render(&$output)
	{
		if(!$this->hasScripts)
			return;

		$this->renderCoreScripts();

		if(!empty($this->scriptMap))
			$this->remapScripts();

		$this->unifyScripts();

		$this->renderHead($output);
		if($this->enableJavaScript)
		{
			$this->renderBodyBegin($output);
			$this->renderBodyEnd($output);
		}
	}


	protected function renderScriptBatch(array $scripts)
	{
		$html = '';
		$scriptBatches = array();
		foreach($scripts as $scriptValue)
		{
			if(is_array($scriptValue))
			{
				$scriptContent = $scriptValue['content'];
				unset($scriptValue['content']);
				$scriptHtmlOptions = $scriptValue;
			}
			else
			{
				$scriptContent = $scriptValue;
				$scriptHtmlOptions = array();
			}
			$key=serialize(ksort($scriptHtmlOptions));
			$scriptBatches[$key]['htmlOptions']=$scriptHtmlOptions;
			$scriptBatches[$key]['scripts'][]=$scriptContent;
		}
		foreach($scriptBatches as $scriptBatch)
			if(!empty($scriptBatch['scripts']))
				if( $this->enableRenderingForAjaxResponse )
				{
					if( isset( $this->scriptStore["js_code"] ) )
						$this->scriptStore["js_code"] = $this->scriptStore["js_code"].implode("\n",$scriptBatch['scripts']);
					else
						$this->scriptStore["js_code"] = implode("\n",$scriptBatch['scripts']);
				}
				else	
					$html.=CHtml::script(implode("\n",$scriptBatch['scripts']),$scriptBatch['htmlOptions'])."\n";
		return $html;
	}


	public function renderHead(&$output)
	{
		$html='';
		foreach($this->metaTags as $meta)
				if( $this->enableRenderingForAjaxResponse )
					$this->scriptStore = $this->scriptStore;//do nothing
				else	
					$html.=CHtml::metaTag($meta['content'],null,null,$meta)."\n";
		foreach($this->linkTags as $link)
				if( $this->enableRenderingForAjaxResponse )
					$this->scriptStore = $this->scriptStore;//do nothing
				else	
					$html.=CHtml::linkTag(null,null,null,null,$link)."\n";
		foreach($this->cssFiles as $url=>$media)
				if( $this->enableRenderingForAjaxResponse )
					$this->scriptStore["css_files"] []= $url;
				else	
					$html.=CHtml::cssFile($url,$media)."\n";
		foreach($this->css as $css)
				if( $this->enableRenderingForAjaxResponse )
					$this->scriptStore["css_code"] = $this->scriptStore["css_code"].$css[0];
				else	
					$html.=CHtml::css($css[0],$css[1])."\n";
		if($this->enableJavaScript)
		{
			if(isset($this->scriptFiles[self::POS_HEAD]))
			{
				foreach($this->scriptFiles[self::POS_HEAD] as $scriptFileValueUrl=>$scriptFileValue)
				{
				if( $this->enableRenderingForAjaxResponse )
					$this->scriptStore["js_files"][] = $scriptFileValueUrl;
				elseif(is_array($scriptFileValue))
						$html.=CHtml::scriptFile($scriptFileValueUrl,$scriptFileValue)."\n";
					else
						$html.=CHtml::scriptFile($scriptFileValueUrl)."\n";
				}
			}

			if(isset($this->scripts[self::POS_HEAD]))
				$html.=$this->renderScriptBatch($this->scripts[self::POS_HEAD]);
		}

		if($html!=='')
		{
			$count=0;
			$output=preg_replace('/(<title\b[^>]*>|<\\/head\s*>)/is','<###head###>$1',$output,1,$count);
			if($count)
				$output=str_replace('<###head###>',$html,$output);
			else
				$output=$html.$output;
		}
	}


	public function renderBodyBegin(&$output)
	{
		$html='';
		if(isset($this->scriptFiles[self::POS_BEGIN]))
		{
			foreach($this->scriptFiles[self::POS_BEGIN] as $scriptFileUrl=>$scriptFileValue)
			{
				if( $this->enableRenderingForAjaxResponse )
					$this->scriptStore["js_files"][] = $scriptFileUrl;
				elseif(is_array($scriptFileValue))
					$html.=CHtml::scriptFile($scriptFileUrl,$scriptFileValue)."\n";
				else
					$html.=CHtml::scriptFile($scriptFileUrl)."\n";
			}
		}
		if(isset($this->scripts[self::POS_BEGIN]))
			$html.=$this->renderScriptBatch($this->scripts[self::POS_BEGIN]);

		if($html!=='')
		{
			$count=0;
			$output=preg_replace('/(<body\b[^>]*>)/is','$1<###begin###>',$output,1,$count);
			if($count)
				$output=str_replace('<###begin###>',$html,$output);
			else
				$output=$html.$output;
		}
	}


	public function renderBodyEnd(&$output)
	{
		if(!isset($this->scriptFiles[self::POS_END]) && !isset($this->scripts[self::POS_END])
			&& !isset($this->scripts[self::POS_READY]) && !isset($this->scripts[self::POS_LOAD]))
			return;

		$fullPage=0;
		$output=preg_replace('/(<\\/body\s*>)/is','<###end###>$1',$output,1,$fullPage);
		$html='';
		if(isset($this->scriptFiles[self::POS_END]))
		{
			foreach($this->scriptFiles[self::POS_END] as $scriptFileUrl=>$scriptFileValue)
			{
				if( $this->enableRenderingForAjaxResponse )
					$this->scriptStore["js_files"][] = $scriptFileUrl;
				elseif(is_array($scriptFileValue))
					$html.=CHtml::scriptFile($scriptFileUrl,$scriptFileValue)."\n";
				else
					$html.=CHtml::scriptFile($scriptFileUrl)."\n";
			}
		}
		$scripts=isset($this->scripts[self::POS_END]) ? $this->scripts[self::POS_END] : array();
		if(isset($this->scripts[self::POS_READY]))
		{
			if($fullPage && !$this->enableRenderingForAjaxResponse )
				$scripts[]="jQuery(function($) {\n".implode("\n",$this->scripts[self::POS_READY])."\n});";
			else
				$scripts[]=implode("\n",$this->scripts[self::POS_READY]);
		}
		if(isset($this->scripts[self::POS_LOAD]))
		{
			if($fullPage && !$this->enableRenderingForAjaxResponse )
				$scripts[]="jQuery(window).on('load',function() {\n".implode("\n",$this->scripts[self::POS_LOAD])."\n});";
			else
				$scripts[]=implode("\n",$this->scripts[self::POS_LOAD]);
		}
		if(!empty($scripts))
			$html.=$this->renderScriptBatch($scripts);

		if($fullPage)
			$output=str_replace('<###end###>',$html,$output);
		else
			$output=$output.$html;
	}

}
