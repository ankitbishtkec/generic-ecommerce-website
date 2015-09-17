<?php
/* @var $this AddressController */
/* @var $model AAddress */

$this->breadcrumbs=array(
	'Aaddresses'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List AAddress', 'url'=>array('index')),
	array('label'=>'Create AAddress', 'url'=>array('create')),
	array('label'=>'Update AAddress', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete AAddress', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage AAddress', 'url'=>array('admin')),
);
?>

<h1>View AAddress #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'house_flat_num',
		'house_name',
		'society_apartment_name',
		'street_name1',
		'street_name2',
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
	),
)); ?>
