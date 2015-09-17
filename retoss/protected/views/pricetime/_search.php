<?php
/* @var $this PriceTimeController */
/* @var $model APriceTime */
/* @var $form CActiveForm */
?>

<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="row">
		<?php echo $form->label($model,'id'); ?>
		<?php echo $form->textField($model,'id',array('size'=>20,'maxlength'=>20)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'price_after_discount'); ?>
		<?php echo $form->textField($model,'price_after_discount',array('size'=>20,'maxlength'=>20)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'margin'); ?>
		<?php echo $form->textField($model,'margin',array('size'=>20,'maxlength'=>20)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'price_time2tiffin'); ?>
		<?php echo $form->textField($model,'price_time2tiffin',array('size'=>20,'maxlength'=>20)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'is_deleted'); ?>
		<?php echo $form->textField($model,'is_deleted',array('size'=>45,'maxlength'=>45)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'discount'); ?>
		<?php echo $form->textField($model,'discount',array('size'=>10,'maxlength'=>10)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'order_start_time'); ?>
		<?php echo $form->textField($model,'order_start_time'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'order_end_time'); ?>
		<?php echo $form->textField($model,'order_end_time'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'order_delivery_time'); ?>
		<?php echo $form->textField($model,'order_delivery_time'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'verified_by'); ?>
		<?php echo $form->textField($model,'verified_by',array('size'=>45,'maxlength'=>45)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'initial_quantity'); ?>
		<?php echo $form->textField($model,'initial_quantity',array('size'=>20,'maxlength'=>20)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'quantity_currently_available'); ?>
		<?php echo $form->textField($model,'quantity_currently_available',array('size'=>20,'maxlength'=>20)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'num_of_orders'); ?>
		<?php echo $form->textField($model,'num_of_orders',array('size'=>20,'maxlength'=>20)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'orderType'); ?>
		<?php echo $form->textField($model,'orderType'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->