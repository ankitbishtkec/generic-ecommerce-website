<?php
/* @var $this OrderController */
/* @var $model AOrder */
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
		<?php echo $form->label($model,'order_unique_id'); ?>
		<?php echo $form->textField($model,'order_unique_id',array('size'=>60,'maxlength'=>400)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'remarks_from_orderer'); ?>
		<?php echo $form->textField($model,'remarks_from_orderer',array('size'=>60,'maxlength'=>100)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'payment_mode'); ?>
		<?php echo $form->textField($model,'payment_mode',array('size'=>45,'maxlength'=>45)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'total_price'); ?>
		<?php echo $form->textField($model,'total_price',array('size'=>20,'maxlength'=>20)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'per_unit_price'); ?>
		<?php echo $form->textField($model,'per_unit_price',array('size'=>20,'maxlength'=>20)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'num_of_units'); ?>
		<?php echo $form->textField($model,'num_of_units',array('size'=>20,'maxlength'=>20)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'ordered_by2user_details'); ?>
		<?php echo $form->textField($model,'ordered_by2user_details',array('size'=>20,'maxlength'=>20)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'order2price_time'); ?>
		<?php echo $form->textField($model,'order2price_time',array('size'=>20,'maxlength'=>20)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'order2tiffin'); ?>
		<?php echo $form->textField($model,'order2tiffin',array('size'=>20,'maxlength'=>20)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'order2address'); ?>
		<?php echo $form->textField($model,'order2address',array('size'=>20,'maxlength'=>20)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'assigned_delivery_boy2user_details'); ?>
		<?php echo $form->textField($model,'assigned_delivery_boy2user_details',array('size'=>20,'maxlength'=>20)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'applied_offer_id'); ?>
		<?php echo $form->textField($model,'applied_offer_id',array('size'=>50,'maxlength'=>50)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'applied_order_amount'); ?>
		<?php echo $form->textField($model,'applied_order_amount',array('size'=>20,'maxlength'=>20)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'is_deleted'); ?>
		<?php echo $form->textField($model,'is_deleted',array('size'=>45,'maxlength'=>45)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'verification_code'); ?>
		<?php echo $form->textField($model,'verification_code',array('size'=>45,'maxlength'=>45)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'order_pickup_time'); ?>
		<?php echo $form->textField($model,'order_pickup_time'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'order_delivery_time'); ?>
		<?php echo $form->textField($model,'order_delivery_time'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'status'); ?>
		<?php echo $form->textField($model,'status',array('size'=>60,'maxlength'=>200)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'last_status_update'); ?>
		<?php echo $form->textField($model,'last_status_update'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'source_phone'); ?>
		<?php echo $form->textField($model,'source_phone',array('size'=>45,'maxlength'=>45)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'destination_phone'); ?>
		<?php echo $form->textField($model,'destination_phone',array('size'=>45,'maxlength'=>45)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'source_address'); ?>
		<?php echo $form->textField($model,'source_address',array('size'=>60,'maxlength'=>200)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'destination_address'); ?>
		<?php echo $form->textField($model,'destination_address',array('size'=>60,'maxlength'=>200)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'source_locality'); ?>
		<?php echo $form->textField($model,'source_locality',array('size'=>50,'maxlength'=>50)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'destination_locality'); ?>
		<?php echo $form->textField($model,'destination_locality',array('size'=>50,'maxlength'=>50)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'rejected_by_delivery_boys_comma_seperated_ids'); ?>
		<?php echo $form->textField($model,'rejected_by_delivery_boys_comma_seperated_ids',array('size'=>60,'maxlength'=>200)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'num_of_rejections_by_delivery_boys'); ?>
		<?php echo $form->textField($model,'num_of_rejections_by_delivery_boys'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'orderType'); ?>
		<?php echo $form->textField($model,'orderType'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'wallet_amount_used'); ?>
		<?php echo $form->textField($model,'wallet_amount_used',array('size'=>20,'maxlength'=>20)); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->