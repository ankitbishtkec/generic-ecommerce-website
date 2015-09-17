<?php
/* @var $this TiffinController */
/* @var $model ATiffin */

$this->breadcrumbs=array(
	'Atiffins'=>array('index'),
	$model->name,
);

$this->menu=array(
	array('label'=>'List ATiffin', 'url'=>array('index')),
	array('label'=>'Create ATiffin', 'url'=>array('create')),
	array('label'=>'Update ATiffin', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete ATiffin', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage ATiffin', 'url'=>array('admin')),
);
?>

<!--h1>View ATiffin #<?php echo $model->id; ?></h1-->

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'name',
		'contents',
	),
)); ?>
