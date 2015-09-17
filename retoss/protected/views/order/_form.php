<?php
/* @var $this OrderController */
/* @var $model AOrder */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'aorder-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'order_unique_id'); ?>
		<?php echo $form->textField($model,'order_unique_id',array('size'=>60,'maxlength'=>400)); ?>
		<?php echo $form->error($model,'order_unique_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'remarks_from_orderer'); ?>
		<?php echo $form->textField($model,'remarks_from_orderer',array('size'=>60,'maxlength'=>100)); ?>
		<?php echo $form->error($model,'remarks_from_orderer'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'payment_mode'); ?>
		<?php echo $form->textField($model,'payment_mode',array('size'=>45,'maxlength'=>45)); ?>
		<?php echo $form->error($model,'payment_mode'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'total_price'); ?>
		<?php echo $form->textField($model,'total_price',array('size'=>20,'maxlength'=>20)); ?>
		<?php echo $form->error($model,'total_price'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'per_unit_price'); ?>
		<?php echo $form->textField($model,'per_unit_price',array('size'=>20,'maxlength'=>20)); ?>
		<?php echo $form->error($model,'per_unit_price'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'num_of_units'); ?>
		<?php echo $form->textField($model,'num_of_units',array('size'=>20,'maxlength'=>20)); ?>
		<?php echo $form->error($model,'num_of_units'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'ordered_by2user_details'); ?>
		<?php echo $form->textField($model,'ordered_by2user_details',array('size'=>20,'maxlength'=>20)); ?>
		<?php echo $form->error($model,'ordered_by2user_details'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'order2price_time'); ?>
		<?php echo $form->textField($model,'order2price_time',array('size'=>20,'maxlength'=>20)); ?>
		<?php echo $form->error($model,'order2price_time'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'order2tiffin'); ?>
		<?php echo $form->textField($model,'order2tiffin',array('size'=>20,'maxlength'=>20)); ?>
		<?php echo $form->error($model,'order2tiffin'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'order2address'); ?>
		<?php echo $form->textField($model,'order2address',array('size'=>20,'maxlength'=>20)); ?>
		<?php echo $form->error($model,'order2address'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'assigned_delivery_boy2user_details'); ?>
		<?php echo $form->textField($model,'assigned_delivery_boy2user_details',array('size'=>20,'maxlength'=>20)); ?>
		<?php echo $form->error($model,'assigned_delivery_boy2user_details'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'applied_offer_id'); ?>
		<?php echo $form->textField($model,'applied_offer_id',array('size'=>50,'maxlength'=>50)); ?>
		<?php echo $form->error($model,'applied_offer_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'applied_order_amount'); ?>
		<?php echo $form->textField($model,'applied_order_amount',array('size'=>20,'maxlength'=>20)); ?>
		<?php echo $form->error($model,'applied_order_amount'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'is_deleted'); ?>
		<?php echo $form->textField($model,'is_deleted',array('size'=>45,'maxlength'=>45)); ?>
		<?php echo $form->error($model,'is_deleted'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'verification_code'); ?>
		<?php echo $form->textField($model,'verification_code',array('size'=>45,'maxlength'=>45)); ?>
		<?php echo $form->error($model,'verification_code'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'order_pickup_time'); ?>
		<?php echo $form->textField($model,'order_pickup_time'); ?>
		<?php echo $form->error($model,'order_pickup_time'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'order_delivery_time'); ?>
		<?php echo $form->textField($model,'order_delivery_time'); ?>
		<?php echo $form->error($model,'order_delivery_time'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'status'); ?>
		<?php echo $form->textField($model,'status',array('size'=>60,'maxlength'=>200)); ?>
		<?php echo $form->error($model,'status'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'last_status_update'); ?>
		<?php echo $form->textField($model,'last_status_update'); ?>
		<?php echo $form->error($model,'last_status_update'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'source_phone'); ?>
		<?php echo $form->textField($model,'source_phone',array('size'=>45,'maxlength'=>45)); ?>
		<?php echo $form->error($model,'source_phone'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'destination_phone'); ?>
		<?php echo $form->textField($model,'destination_phone',array('size'=>45,'maxlength'=>45)); ?>
		<?php echo $form->error($model,'destination_phone'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'source_address'); ?>
		<?php echo $form->textField($model,'source_address',array('size'=>60,'maxlength'=>200)); ?>
		<?php echo $form->error($model,'source_address'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'destination_address'); ?>
		<?php echo $form->textField($model,'destination_address',array('size'=>60,'maxlength'=>200)); ?>
		<?php echo $form->error($model,'destination_address'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'source_locality'); ?>
		<?php echo $form->textField($model,'source_locality',array('size'=>50,'maxlength'=>50)); ?>
		<?php echo $form->error($model,'source_locality'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'destination_locality'); ?>
		<?php echo $form->textField($model,'destination_locality',array('size'=>50,'maxlength'=>50)); ?>
		<?php echo $form->error($model,'destination_locality'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'rejected_by_delivery_boys_comma_seperated_ids'); ?>
		<?php echo $form->textField($model,'rejected_by_delivery_boys_comma_seperated_ids',array('size'=>60,'maxlength'=>200)); ?>
		<?php echo $form->error($model,'rejected_by_delivery_boys_comma_seperated_ids'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'num_of_rejections_by_delivery_boys'); ?>
		<?php echo $form->textField($model,'num_of_rejections_by_delivery_boys'); ?>
		<?php echo $form->error($model,'num_of_rejections_by_delivery_boys'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'orderType'); ?>
		<?php echo $form->textField($model,'orderType'); ?>
		<?php echo $form->error($model,'orderType'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'wallet_amount_used'); ?>
		<?php echo $form->textField($model,'wallet_amount_used',array('size'=>20,'maxlength'=>20)); ?>
		<?php echo $form->error($model,'wallet_amount_used'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->