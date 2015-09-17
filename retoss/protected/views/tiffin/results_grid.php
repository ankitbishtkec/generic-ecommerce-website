<div id='result_table' >
		<!--div id='advanced_search' class='col-sm-3 col-xs-10 col-xs-offset-1 col-sm-offset-0' -->
		<div id='advanced_search' class='' style=";" >
			<div class="alert alert-info alert-dismissible visible-xs-block" role="alert">
  				<button type="button" class="close" data-dismiss="alert" aria-label="Close">
  					<span aria-hidden="true">&times;</span>
  				</button>
  				<strong>
  					Scroll down to view the available tiffins.
  				</strong>
			</div>
			<?php
				echo "<b style='font-size:10px;margin-bottom: 0px;'>Sort:</b>";	
				echo "<br>";
				echo CHtml::dropDownList("sort_name", $arrayArgs["sort"][0], array(
				"rating" => "rating",
				"delivery time increasing" => "delivery time increasing",
				"delivery time decreasing" => "delivery time decreasing",
				"price increasing" => "price increasing",
				"price decreasing" => "price decreasing",
				), array('style'=>'font-size:15px;margin-bottom: 5px;','class'=>'form-control input-sm',));
				
				echo "<b style='font-size:10px;margin-bottom: 0px;'>Localities:</b>";	
				echo "<br>";
				echo CHtml::dropDownList("tech_park", $arrayArgs["location"][0], $locality_arr,
				 array('style'=>'font-size:15px;margin-bottom: 5px;','class'=>'form-control input-sm',));
  				
				echo "<b style='font-size:10px;margin-bottom: 0px;'>From delivery date:</b>";	
				echo "<br>";
				$this->widget('ext.YiiDateTimePicker.jqueryDateTime', array(
        			'name' => 'from_delivery_date',
        			'id'=>'from_delivery_date',
        			'options' => array(
							'format'=>'Y-m-d H:i:00',
        					'value' => $arrayArgs["date-start"][0],
							'timepicker'=>true,
							'closeOnDateSelect'=>true,
							//'minDate'=>$today,
						), //DateTimePicker options
        			'htmlOptions' => array('style'=>'font-size:15px;margin-bottom: 5px;','class'=>'form-control input-sm',),
    			));
    			
				echo "<b style='font-size:10px;margin-bottom: 0px;'>To delivery date:</b>";	
				echo "<br>";
				$this->widget('ext.YiiDateTimePicker.jqueryDateTime', array(
        			'name' => 'to_delivery_date',
        			'id'=>'to_delivery_date',
        			'options' => array(
							'format'=>'Y-m-d H:i:00',
        					'value' => $arrayArgs["date-end"][0],
							'timepicker'=>true,
							'closeOnDateSelect'=>true,
							//'minDate'=>$today,
						), //DateTimePicker options
        			'htmlOptions' => array('style'=>'font-size:15px;margin-bottom: 5px;','class'=>'form-control input-sm',),
    			));	
			?>
			<b style='font-size:10px;margin-bottom: 0px;'>Tags:</b>	
			<br>
			<div id='tags_filters_panel' style='overflow:auto; width:220px;max-height:120px; width: 100%;
			border: 1px solid #ccc; border-radius: 3px;padding-left: 10px; padding-top: 10px;'>
			<?php
			$addHtmlLine = false;
			if( isset( $arrayArgs['tags'] ) )
			{
				foreach( $arrayArgs['tags'] as $i)
				{
					if( isset($tagsfiltersArr[ $i ] ) )
					{
						echo CHtml::checkBox( "tags_filter_checkbox", true, array('data-value'=>$i) );
						echo "<i> ".$i."</i>"." (".$tagsfiltersArr[ $i ].")";
						echo "<br>";
						unset( $tagsfiltersArr[ $i ] );
						$addHtmlLine = true;
					}
				}
				if( $addHtmlLine )
				{
					echo "<hr style='margin-top:8px;margin-bottom:8px;'>";
					$addHtmlLine = false;
				}
			}
			
			foreach( $tagsfiltersArr as $i=>$v)
			{
				echo CHtml::checkBox( "tags_filter_checkbox", false, array('data-value'=>$i) );
				echo "<i> ".$i."</i>"." (".$tagsfiltersArr[ $i ].")";
				echo "<br>";
			}
			
			?>
			</div>
				
			<b style='font-size:10px;margin-bottom: 0px;'>Chefs:</b>	
			<br>
			<div id='chefs_filters_panel' style='overflow:auto; width:220px;max-height:120px; width: 100%;
			border: 1px solid #ccc; border-radius: 3px;padding-left: 10px; padding-top: 10px;'>
			<?php
			$addHtmlLine = false;
			if( isset( $arrayArgs['chefs'] ) )
			{
				foreach( $arrayArgs['chefs'] as $i)
				{
					if( isset($chefsfiltersArr[ $i ] ) )
					{
						echo CHtml::checkBox( "chefs_filter_checkbox", true, array('data-value'=>$i) );
						echo "<i> ".$i."</i>"." (".$chefsfiltersArr[ $i ].")";
						echo "<br>";
						unset( $chefsfiltersArr[ $i ] );
						$addHtmlLine = true;
					}
				}
				if( $addHtmlLine )
				{
					echo "<hr style='margin-top:8px;margin-bottom:8px;'>";
					$addHtmlLine = false;
				}
			}
			
			foreach( $chefsfiltersArr as $i=>$v)
			{
				echo CHtml::checkBox( "chefs_filter_checkbox", false, array('data-value'=>$i) );
				echo "<i> ".$i."</i>"." (".$chefsfiltersArr[ $i ].")";
				echo "<br>";
			}
				
			// In the div id named 'loading' in below html code. background-color css property has been replaced by
			// background-image property. This background image is transparent 1x1 px. As IE 8 was not respecting z-index 
			// with background-color property( no color was shown and mouse event was available to below div ). After,
			// using background-image property z-index is being respected (image is shown and mouse event is stopped and
			// are not allowed to passed to below div )
			?>
			</div>
			<hr>
			<br>
		</div>

		
		<!--div  class='col-sm-9 col-xs-10 col-xs-offset-1 col-sm-offset-0' id='results'-->
		<div  class='col-xs-12' id='results'>
			<div class="row" style="position: relative;" >
			<div id="loading" style="display: none;z-index: 902;position: absolute; left: 0px;top: 0px;
			/*background-color: rgba(245, 220, 222, 0.44)*/
			background-image:url('<?php echo AppCommon::getAppFolderUrl();?>/images/loading_mask_shadow.png');width:100%;height:100%;">
				<div class="content" style="top: 40%;right:40%;position: fixed;z-index:1002;"> 
					<span><b>Loading...  </b></span>
					<img src="<?php echo AppCommon::getAppFolderUrl();?>/images/loading.gif" alt=""> 
				</div>
			</div>
			<div class="text-center" style="min-height: 40px; padding-top: 10px;" role="alert">
				<b><?php echo count( $selectedTiffins );?></b> tiffin(s) are available.
			</div>  
			<?php 
			foreach ($selectedTiffins as $value) {
				$imagePath = null;
				if( isset( $value->image ) )
					$imagePath = AppCommon::getAppFolderUrl().'/images/tiffin_images/'.$value->image;
				else
					$imagePath = AppCommon::getAppFolderUrl().'/images/tiffin_images/5.jpg';//default image
				$this->renderPartial('single_result_element1', array(
					'data'=>$value,
					'imagePath'=>$imagePath,
				), false, false); 	
			}
			?>
		</div>
		</div>
</div>



