<?php
/* @var $this UserDetailsController */
/* @var $data AUserDetails */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('is_active')); ?>:</b>
	<?php echo CHtml::encode($data->is_active); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('user_type')); ?>:</b>
	<?php echo CHtml::encode($data->user_type); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('first_name')); ?>:</b>
	<?php echo CHtml::encode($data->first_name); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('last_name')); ?>:</b>
	<?php echo CHtml::encode($data->last_name); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('dob')); ?>:</b>
	<?php echo CHtml::encode($data->dob); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('user_details2time_details')); ?>:</b>
	<?php echo CHtml::encode($data->user_details2time_details); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('person_details2photo')); ?>:</b>
	<?php echo CHtml::encode($data->person_details2photo); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('person_details2address')); ?>:</b>
	<?php echo CHtml::encode($data->person_details2address); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('person_details2phone')); ?>:</b>
	<?php echo CHtml::encode($data->person_details2phone); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('person_details2email')); ?>:</b>
	<?php echo CHtml::encode($data->person_details2email); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('expiry_date_of_tiffinwala')); ?>:</b>
	<?php echo CHtml::encode($data->expiry_date_of_tiffinwala); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('rating_of_tiffinwala')); ?>:</b>
	<?php echo CHtml::encode($data->rating_of_tiffinwala); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('is_deleted')); ?>:</b>
	<?php echo CHtml::encode($data->is_deleted); ?>
	<br />

	*/ ?>

</div>