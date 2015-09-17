<?php
/* @var $this PriceTimeController */
/* @var $model APriceTime */

$this->breadcrumbs=array(
	'Aprice Times'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>'List APriceTime', 'url'=>array('index')),
	array('label'=>'Create APriceTime', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#aprice-time-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Manage Aprice Times</h1>

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
	'id'=>'aprice-time-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'id',
		'price_after_discount',
		'margin',
		'price_time2tiffin',
		'is_deleted',
		'discount',
		/*
		'order_start_time',
		'order_end_time',
		'order_delivery_time',
		'verified_by',
		'initial_quantity',
		'quantity_currently_available',
		'num_of_orders',
		'orderType',
		*/
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
