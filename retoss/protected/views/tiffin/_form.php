<?php
/* @var $this TiffinController */
/* @var $model ATiffin */
/* @var $form CActiveForm */
?>

<div class="form">
<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'atiffin-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableClientValidation'=>true,
)); ?>

<hr>
<?php echo $form->errorSummary($model); ?>

<table border="1">
	<tbody>
		<tr>
			<th>
				Tiffin Photo
			</th>
			<th>
				<?php echo $form->labelEx($model,'name'); ?>	
			</th>
			<th>	
				<?php echo $form->labelEx($model,'contents'); ?>	
			</th>
			<th>
				<?php echo $form->labelEx($model,'verified_by'); ?>
			</th>
		</tr>
		<tr>
			<td>
				
			</td>
			<td>
				<?php echo $form->textField($model,'name',array('size'=>45,'maxlength'=>45)); ?>
				<?php echo $form->error($model,'name'); ?>
			</td>
			<td>
				<?php echo $form->textArea($model,'contents',array('size'=>60,'maxlength'=>200)); ?>
				<?php echo $form->error($model,'contents'); ?>
			</td>
			<td>
				<?php echo $form->textField($model,'verified_by',array('size'=>45,'maxlength'=>45, 'readonly'=>1)); ?>
			</td>
		</tr>
	</tbody>
</table>
	
<br>
	<div id="tagsid">
        <?php
        	//get all tags from tags table in db start -ankit
        	$allTagRows = AFoodTags::model()->findAll();
        	$allTagNames = array();
			foreach( $allTagRows as $eachrow)
				$allTagNames[ $eachrow->tag_name ]=  $eachrow->tag_name;
        	//get all tags from tags table in db stop -ankit

        	//get all tags from tags table in current tiffin start -ankit			
			$tagRows = $model->aFoodTags;
			$tagNames = array();
			foreach( $tagRows as $row)
				$tagNames[]= $row->tag_name;
        	//get all tags from tags table in current tiffin stop -ankit				
			
        	$this->widget('ext.tag.TagWidget', array(
            	'data'=> $allTagNames,
            	'tags' => $tagNames
        ));
        ?>
	</div>
	
<br>
<div id="pricetime">
	<h4>Tiffin-details Table</h4>
	<table id="pricetimetable" style="width:100%" border="1">
		<tbody>
			<tr>
				<th>Order Start Time ,
				<br>Order End Time and
				<br>Order Pickup Time</th>
				<th>Price after Discount and
				<br>Discount (%)</th>
				<th>Quantity</th>
				<th>Verified By</th>
			</tr>
		<?php
        		$index = 0;
        		foreach ($model->aPriceTimes as $id => $child)
				{
            		$this->actionGetPriceTimeUI( $index, $child);
            		$index++;
				}
				$hr = Yii::app()->getRequest();
				$baseurl = $hr->getHostInfo().$hr->getScriptUrl();
				Yii::app()->clientScript->
				registerScript(__CLASS__.'#'."b","var globalIndex = " .$index.";",CClientScript::POS_END);
        ?>
       	</tbody>
       </table> 
<br>   
<?php
	echo CHtml::link('Add new tiffin-details row', '#', array('id' => 'GetPriceTimeUI'));
?>
</div>
<br>
<div class="row buttons">
	<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
</div>

<?php $this->endWidget(); ?>

<?php
//script -start
$cs = Yii::app()->getClientScript();
$path = Yii::app()->getBasePath().'/jsFiles/';
Yii::app()->assetManager->publish($path, true, -1, false);
$path1 =  Yii::app()->assetManager->getPublishedUrl(  $path );
$cs->registerScriptFile( $path1.'/resourceLoaderDynamic.js');
$cs->registerScriptFile( $path1.'/tiffinCreateUpdate.js');
Yii::app()->clientScript->registerScript(__CLASS__.'#'."a","initializePage();");
//script -stop 
 ?>

</div><!-- form -->