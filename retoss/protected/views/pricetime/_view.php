<?php
/* @var $this PriceTimeController */
/* @var $data APriceTime */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('price_after_discount')); ?>:</b>
	<?php echo CHtml::encode($data->price_after_discount); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('margin')); ?>:</b>
	<?php echo CHtml::encode($data->margin); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('price_time2tiffin')); ?>:</b>
	<?php echo CHtml::encode($data->price_time2tiffin); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('is_deleted')); ?>:</b>
	<?php echo CHtml::encode($data->is_deleted); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('discount')); ?>:</b>
	<?php echo CHtml::encode($data->discount); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('order_start_time')); ?>:</b>
	<?php echo CHtml::encode($data->order_start_time); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('order_end_time')); ?>:</b>
	<?php echo CHtml::encode($data->order_end_time); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('order_delivery_time')); ?>:</b>
	<?php echo CHtml::encode($data->order_delivery_time); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('verified_by')); ?>:</b>
	<?php echo CHtml::encode($data->verified_by); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('initial_quantity')); ?>:</b>
	<?php echo CHtml::encode($data->initial_quantity); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('quantity_currently_available')); ?>:</b>
	<?php echo CHtml::encode($data->quantity_currently_available); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('num_of_orders')); ?>:</b>
	<?php echo CHtml::encode($data->num_of_orders); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('orderType')); ?>:</b>
	<?php echo CHtml::encode($data->orderType); ?>
	<br />

	*/ ?>

</div>