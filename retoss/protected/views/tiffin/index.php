<?php
/* only JS is rendered here. remaining part is handle in other views */
?>

<?php 
$cs = Yii::app()->getClientScript();
$path = Yii::app()->getBasePath().'/jsFiles/';
Yii::app()->assetManager->publish($path, true, -1, false);
$path1 =  Yii::app()->assetManager->getPublishedUrl(  $path );
$cs->registerScriptFile( $path1.'/resourceLoaderDynamic.js');
//$cs->registerScriptFile( $path1.'/cart.js');//moved to main.php layout file
$cs->registerScriptFile( $path1.'/tiffinIndex.js');
Yii::app()->clientScript->registerScript(__CLASS__.'#'."a","initializePage();");

echo "<div id='results_grid' >";
$this->renderPartial('results_grid', array(
			'selectedTiffins'=>$selectedTiffins,
			'chefsfiltersArr'=>$chefsfiltersArr,
			'tagsfiltersArr'=>$tagsfiltersArr,
			'arrayArgs'=>$arrayArgs,
			'locality_arr'=>$locality_arr,
		), false, false); 
echo "</div>";
?>


