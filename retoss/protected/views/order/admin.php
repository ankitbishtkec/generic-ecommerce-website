<?php
/* @var $this OrderController */
/* @var $model AOrder */

$this->breadcrumbs=array(
	'Aorders'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>'List AOrder', 'url'=>array('index')),
	array('label'=>'Create AOrder', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#aorder-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Manage Aorders</h1>

<p>
You may optionally enter a comparison operator (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b>
or <b>=</b>) at the beginning of each of your search values to specify how the comparison should be done.
</p>

<?php echo CHtml::link('Advanced Search','#',array('class'=>'search-button')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'aorder-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'id',
		'order_unique_id',
		'remarks_from_orderer',
		'payment_mode',
		'total_price',
		'per_unit_price',
		/*
		'num_of_units',
		'ordered_by2user_details',
		'order2price_time',
		'order2tiffin',
		'order2address',
		'assigned_delivery_boy2user_details',
		'applied_offer_id',
		'applied_order_amount',
		'is_deleted',
		'verification_code',
		'order_pickup_time',
		'order_delivery_time',
		'status',
		'last_status_update',
		'source_phone',
		'destination_phone',
		'source_address',
		'destination_address',
		'source_locality',
		'destination_locality',
		'rejected_by_delivery_boys_comma_seperated_ids',
		'num_of_rejections_by_delivery_boys',
		'orderType',
		'wallet_amount_used',
		*/
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
