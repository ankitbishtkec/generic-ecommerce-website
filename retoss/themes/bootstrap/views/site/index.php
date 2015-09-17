<?php
/* @var $this SiteController */

$this->pageTitle=Yii::app()->name;
?>
<div class="jumbotron" style="color: white; background-color: inherit;text-shadow: 1px 1px #000000;">
  <h1>Welcome to tw.in</h1>
  <p>Now get healthy, hygienic and tasty lunches/ dinners delivered at your home and office. Free delivery, no minimum order value, new recipes everytime, smartly packaged hot food, 15 to 45 minutes delivery.</p>

<div class="dropdown" style="filter: alpha(opacity=100); opacity: 1;">
  <button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-expanded="true">
    Select your location
    <span class="caret"></span>
  </button>
  <ul class="dropdown-menu" role="menu" aria-labelledby="dropdownMenu1" style="text-shadow:none;">
  	<?php
  	$baseUrl = Yii::app()->getRequest()->getHostInfo().Yii::app()->getRequest()->getScriptUrl();
  	foreach( $locality_arr as $curr )
		echo '<li role="presentation"><a role="menuitem" tabindex="-1" href="'.$baseUrl.
		'/tiffin/index/filters/location='.$curr.'">'.$curr.'</a></li>';
  	?>
  </ul>
</div>
</div>


<?php
$cs = Yii::app()->getClientScript();
$path = Yii::app()->getBasePath().'/jsFiles/';
Yii::app()->assetManager->publish($path, true, -1, false);
$path1 =  Yii::app()->assetManager->getPublishedUrl(  $path );
$cs->registerScriptFile( $path1.'/siteIndex.js');
Yii::app()->clientScript->registerScript(__CLASS__.'#'."a","initializePage();");
?>

