<?php
/* @var $this AddressController */
/* @var $data AAddress */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('house_flat_num')); ?>:</b>
	<?php echo CHtml::encode($data->house_flat_num); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('house_name')); ?>:</b>
	<?php echo CHtml::encode($data->house_name); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('society_apartment_name')); ?>:</b>
	<?php echo CHtml::encode($data->society_apartment_name); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('street_name1')); ?>:</b>
	<?php echo CHtml::encode($data->street_name1); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('street_name2')); ?>:</b>
	<?php echo CHtml::encode($data->street_name2); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('locality')); ?>:</b>
	<?php echo CHtml::encode($data->locality); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('landmark')); ?>:</b>
	<?php echo CHtml::encode($data->landmark); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('city')); ?>:</b>
	<?php echo CHtml::encode($data->city); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('pin')); ?>:</b>
	<?php echo CHtml::encode($data->pin); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('state')); ?>:</b>
	<?php echo CHtml::encode($data->state); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('country')); ?>:</b>
	<?php echo CHtml::encode($data->country); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('is_active')); ?>:</b>
	<?php echo CHtml::encode($data->is_active); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('creation_time')); ?>:</b>
	<?php echo CHtml::encode($data->creation_time); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('is_deleted')); ?>:</b>
	<?php echo CHtml::encode($data->is_deleted); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('meta_data')); ?>:</b>
	<?php echo CHtml::encode($data->meta_data); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('link')); ?>:</b>
	<?php echo CHtml::encode($data->link); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('link_table')); ?>:</b>
	<?php echo CHtml::encode($data->link_table); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('address2bangalore_localities')); ?>:</b>
	<?php echo CHtml::encode($data->address2bangalore_localities); ?>
	<br />

	*/ ?>

</div>