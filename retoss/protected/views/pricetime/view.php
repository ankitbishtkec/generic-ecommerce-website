<?php
/* @var $this PriceTimeController */
/* @var $model APriceTime */

$this->breadcrumbs=array(
	'Aprice Times'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List APriceTime', 'url'=>array('index')),
	array('label'=>'Create APriceTime', 'url'=>array('create')),
	array('label'=>'Update APriceTime', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete APriceTime', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage APriceTime', 'url'=>array('admin')),
);
?>

<h1>View APriceTime #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'price_after_discount',
		'margin',
		'price_time2tiffin',
		'is_deleted',
		'discount',
		'order_start_time',
		'order_end_time',
		'order_delivery_time',
		'verified_by',
		'initial_quantity',
		'quantity_currently_available',
		'num_of_orders',
		'orderType',
	),
)); ?>
