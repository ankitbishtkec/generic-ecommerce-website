<?php
/* @var $this CartController */
/* @var $data ACart */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('added_time')); ?>:</b>
	<?php echo CHtml::encode($data->added_time); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('cart2tiffin')); ?>:</b>
	<?php echo CHtml::encode($data->cart2tiffin); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('cart2user')); ?>:</b>
	<?php echo CHtml::encode($data->cart2user); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('quantity')); ?>:</b>
	<?php echo CHtml::encode($data->quantity); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('status')); ?>:</b>
	<?php echo CHtml::encode($data->status); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('meta_data')); ?>:</b>
	<?php echo CHtml::encode($data->meta_data); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('is_deleted')); ?>:</b>
	<?php echo CHtml::encode($data->is_deleted); ?>
	<br />

	*/ ?>

</div>