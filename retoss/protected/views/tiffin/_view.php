<?php
/* @var $this TiffinController */
/* @var $data ATiffin */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('name')); ?>:</b>
	<?php echo CHtml::encode($data->name); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('contents')); ?>:</b>
	<?php echo CHtml::encode($data->contents); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('availabilty_date')); ?>:</b>
	<?php echo CHtml::encode($data->availabilty_date); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('order_start_time')); ?>:</b>
	<?php echo CHtml::encode($data->order_start_time); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('order_end_time')); ?>:</b>
	<?php echo CHtml::encode($data->order_end_time); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('order_serving_or_delivery_time')); ?>:</b>
	<?php echo CHtml::encode($data->order_serving_or_delivery_time); ?>
	<br />

	<b> vender name </b>
	<?php echo CHtml::encode($data->tiffin2userDetails->first_name."  ".$data->tiffin2userDetails->last_name); ?>
	<br>
	<b> tags</b>
	<?php 
	unset( $data->aFoodTags );
	$drt = $data->aFoodTags;
	foreach($drt as $tag )
	{
		echo CHtml::encode( $tag->tag_name." / " ); 
	}
	
	?>	
	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('verified_by')); ?>:</b>
	<?php echo CHtml::encode($data->verified_by); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('ranking_index')); ?>:</b>
	<?php echo CHtml::encode($data->ranking_index); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('tiffin2user_details')); ?>:</b>
	<?php echo CHtml::encode($data->tiffin2user_details); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('is_deleted')); ?>:</b>
	<?php echo CHtml::encode($data->is_deleted); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('num_of_orders')); ?>:</b>
	<?php echo CHtml::encode($data->num_of_orders); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('num_of_reviews')); ?>:</b>
	<?php echo CHtml::encode($data->num_of_reviews); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('rating_of_tiffin')); ?>:</b>
	<?php echo CHtml::encode($data->rating_of_tiffin); ?>
	<br />

	*/ ?>

</div>