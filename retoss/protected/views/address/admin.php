<?php
/* @var $this AddressController */
/* @var $model AAddress */

$this->breadcrumbs=array(
	'Aaddresses'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>'List AAddress', 'url'=>array('index')),
	array('label'=>'Create AAddress', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#aaddress-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Manage Aaddresses</h1>

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
	'id'=>'aaddress-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'id',
		'house_flat_num',
		'house_name',
		'society_apartment_name',
		'street_name1',
		'street_name2',
		/*
		'locality',
		'landmark',
		'city',
		'pin',
		'state',
		'country',
		'is_active',
		'creation_time',
		'is_deleted',
		'meta_data',
		'link',
		'link_table',
		'address2bangalore_localities',
		*/
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
