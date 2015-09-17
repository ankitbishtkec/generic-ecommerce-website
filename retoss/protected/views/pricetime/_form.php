<?php
/* @var $this PriceTimeController */
/* @var $model APriceTime */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'aprice-time-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'price_after_discount'); ?>
		<?php echo $form->textField($model,'price_after_discount',array('size'=>20,'maxlength'=>20)); ?>
		<?php echo $form->error($model,'price_after_discount'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'margin'); ?>
		<?php echo $form->textField($model,'margin',array('size'=>20,'maxlength'=>20)); ?>
		<?php echo $form->error($model,'margin'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'price_time2tiffin'); ?>
		<?php echo $form->textField($model,'price_time2tiffin',array('size'=>20,'maxlength'=>20)); ?>
		<?php echo $form->error($model,'price_time2tiffin'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'is_deleted'); ?>
		<?php echo $form->textField($model,'is_deleted',array('size'=>45,'maxlength'=>45)); ?>
		<?php echo $form->error($model,'is_deleted'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'discount'); ?>
		<?php echo $form->textField($model,'discount',array('size'=>10,'maxlength'=>10)); ?>
		<?php echo $form->error($model,'discount'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'order_start_time'); ?>
		<?php echo $form->textField($model,'order_start_time'); ?>
		<?php echo $form->error($model,'order_start_time'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'order_end_time'); ?>
		<?php echo $form->textField($model,'order_end_time'); ?>
		<?php echo $form->error($model,'order_end_time'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'order_delivery_time'); ?>
		<?php echo $form->textField($model,'order_delivery_time'); ?>
		<?php echo $form->error($model,'order_delivery_time'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'verified_by'); ?>
		<?php echo $form->textField($model,'verified_by',array('size'=>45,'maxlength'=>45)); ?>
		<?php echo $form->error($model,'verified_by'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'initial_quantity'); ?>
		<?php echo $form->textField($model,'initial_quantity',array('size'=>20,'maxlength'=>20)); ?>
		<?php echo $form->error($model,'initial_quantity'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'quantity_currently_available'); ?>
		<?php echo $form->textField($model,'quantity_currently_available',array('size'=>20,'maxlength'=>20)); ?>
		<?php echo $form->error($model,'quantity_currently_available'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'num_of_orders'); ?>
		<?php echo $form->textField($model,'num_of_orders',array('size'=>20,'maxlength'=>20)); ?>
		<?php echo $form->error($model,'num_of_orders'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'orderType'); ?>
		<?php echo $form->textField($model,'orderType'); ?>
		<?php echo $form->error($model,'orderType'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->