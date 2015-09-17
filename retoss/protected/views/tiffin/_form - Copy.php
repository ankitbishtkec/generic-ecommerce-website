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

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'name'); ?>
		<?php echo $form->textField($model,'name',array('size'=>45,'maxlength'=>45)); ?>
		<?php echo $form->error($model,'name'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'contents'); ?>
		<?php echo $form->textArea($model,'contents',array('size'=>60,'maxlength'=>200)); ?>
		<?php echo $form->error($model,'contents'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'availabilty_date'); ?>
		<?php /*echo $form->dateField($model,'availabilty_date');*/ ?>
		<?php 
			$today = date("Y-m-d"); 
			$this->widget('ext.YiiDateTimePicker.jqueryDateTime', array(
        		'model' => $model,
        		'attribute' => 'availabilty_date',
        		'options' => array(
							'format'=>'Y-m-d',
							'timepicker'=>false,
							'minDate'=>$today,
					), //DateTimePicker options
        		'htmlOptions' => array(
							'autocomplete'=>"off"
				),
    		));		
		?>
		<?php echo $form->error($model,'availabilty_date'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'order_start_time'); ?>
		<?php /*echo $form->timeField($model,'order_start_time');*/ ?>
		<?php 
			$this->widget('ext.YiiDateTimePicker.jqueryDateTime', array(
        		'model' => $model,
        		'attribute' => 'order_start_time',
        		'options' => array(
						'format'=>'Y-m-d H:i:00',
					), //DateTimePicker options
        		'htmlOptions' => array(
							'autocomplete'=>"off"
				),
    		));		
		?>
		<?php echo $form->error($model,'order_start_time'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'order_end_time'); ?>
		<?php /*echo $form->textField($model,'order_end_time');*/ ?>
		<?php 
			$this->widget('ext.YiiDateTimePicker.jqueryDateTime', array(
        		'model' => $model,
        		'attribute' => 'order_end_time',
        		'options' => array(
						'format'=>'Y-m-d H:i:00',
					), //DateTimePicker options
        		'htmlOptions' => array(
							'autocomplete'=>"off"
				),
    		));		
		?>
		<?php echo $form->error($model,'order_end_time'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'order_serving_or_delivery_time'); ?>
		<?php /*echo $form->textField($model,'order_serving_or_delivery_time');*/ ?>
		<?php 
			$this->widget('ext.YiiDateTimePicker.jqueryDateTime', array(
        		'model' => $model,
        		'attribute' => 'order_serving_or_delivery_time',
        		'options' => array(
						'format'=>'Y-m-d H:i:00',
					), //DateTimePicker options
        		'htmlOptions' => array(
							'autocomplete'=>"off"
				),
    		));		
		?>
		<?php echo $form->error($model,'order_serving_or_delivery_time'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'verified_by'); ?>
		<?php echo $form->textField($model,'verified_by',array('size'=>45,'maxlength'=>45)); ?>
		<?php echo $form->error($model,'verified_by'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'quantity_available'); ?>
		<?php echo $form->textField($model,'quantity_available',array('size'=>20,'maxlength'=>20)); ?>
		<?php echo $form->error($model,'quantity_available'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'initial_quantity'); ?>
		<?php echo $form->textField($model,'initial_quantity',array('size'=>20,'maxlength'=>20)); ?>
		<?php echo $form->error($model,'initial_quantity'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'ranking_index'); ?>
		<?php echo $form->textField($model,'ranking_index',array('id'=>'haha')); ?>
		<?php echo $form->error($model,'ranking_index',array('inputID'=>'haha')); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'is_verified'); ?>
		<?php echo $form->textField($model,'is_verified'); ?>
		<?php echo $form->error($model,'is_verified'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'tiffin2user_details'); ?>
		<?php echo $form->textField($model,'tiffin2user_details',array('size'=>20,'maxlength'=>20)); ?>
		<?php echo $form->error($model,'tiffin2user_details'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'is_deleted'); ?>
		<?php echo $form->textField($model,'is_deleted',array('size'=>45,'maxlength'=>45)); ?>
		<?php echo $form->error($model,'is_deleted'); ?>
	</div>
	
	<div id="pricetime">
		<h4>Price-time Table</h4>
		<table id="pricetimetable" style="width:70%">
			<tbody>
				<tr>
					<th>Time</th>
					<th>Price</th>
					<th>Discount</th>
				</tr>
			<?php
        			$index = 0;
        			foreach ($model->aPriceTimes as $id => $child)
					{
            			$this->actionGetPriceTimeUI( $index, $model);
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
   		echo CHtml::link('Add new price-time row', '#', array('id' => 'GetPriceTimeUI'));
   ?>
	</div>
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
$cs->registerScriptFile( $path1.'/tiffinCreateUpdate.js');
Yii::app()->clientScript->registerScript(__CLASS__.'#'."a","initializePage();");
//script -stop 
 ?>

</div><!-- form -->