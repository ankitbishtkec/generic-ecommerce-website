<?php
/* @var $this OrderController */
/* @var $data AOrder */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('order_unique_id')); ?>:</b>
	<?php echo CHtml::encode($data->order_unique_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('remarks_from_orderer')); ?>:</b>
	<?php echo CHtml::encode($data->remarks_from_orderer); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('payment_mode')); ?>:</b>
	<?php echo CHtml::encode($data->payment_mode); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('total_price')); ?>:</b>
	<?php echo CHtml::encode($data->total_price); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('per_unit_price')); ?>:</b>
	<?php echo CHtml::encode($data->per_unit_price); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('num_of_units')); ?>:</b>
	<?php echo CHtml::encode($data->num_of_units); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('ordered_by2user_details')); ?>:</b>
	<?php echo CHtml::encode($data->ordered_by2user_details); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('order2price_time')); ?>:</b>
	<?php echo CHtml::encode($data->order2price_time); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('order2tiffin')); ?>:</b>
	<?php echo CHtml::encode($data->order2tiffin); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('order2address')); ?>:</b>
	<?php echo CHtml::encode($data->order2address); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('assigned_delivery_boy2user_details')); ?>:</b>
	<?php echo CHtml::encode($data->assigned_delivery_boy2user_details); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('applied_offer_id')); ?>:</b>
	<?php echo CHtml::encode($data->applied_offer_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('applied_order_amount')); ?>:</b>
	<?php echo CHtml::encode($data->applied_order_amount); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('is_deleted')); ?>:</b>
	<?php echo CHtml::encode($data->is_deleted); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('verification_code')); ?>:</b>
	<?php echo CHtml::encode($data->verification_code); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('order_pickup_time')); ?>:</b>
	<?php echo CHtml::encode($data->order_pickup_time); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('order_delivery_time')); ?>:</b>
	<?php echo CHtml::encode($data->order_delivery_time); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('status')); ?>:</b>
	<?php echo CHtml::encode($data->status); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('last_status_update')); ?>:</b>
	<?php echo CHtml::encode($data->last_status_update); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('source_phone')); ?>:</b>
	<?php echo CHtml::encode($data->source_phone); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('destination_phone')); ?>:</b>
	<?php echo CHtml::encode($data->destination_phone); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('source_address')); ?>:</b>
	<?php echo CHtml::encode($data->source_address); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('destination_address')); ?>:</b>
	<?php echo CHtml::encode($data->destination_address); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('source_locality')); ?>:</b>
	<?php echo CHtml::encode($data->source_locality); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('destination_locality')); ?>:</b>
	<?php echo CHtml::encode($data->destination_locality); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('rejected_by_delivery_boys_comma_seperated_ids')); ?>:</b>
	<?php echo CHtml::encode($data->rejected_by_delivery_boys_comma_seperated_ids); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('num_of_rejections_by_delivery_boys')); ?>:</b>
	<?php echo CHtml::encode($data->num_of_rejections_by_delivery_boys); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('orderType')); ?>:</b>
	<?php echo CHtml::encode($data->orderType); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('wallet_amount_used')); ?>:</b>
	<?php echo CHtml::encode($data->wallet_amount_used); ?>
	<br />

	*/ ?>

</div>