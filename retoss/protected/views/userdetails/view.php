<?php
/* @var $this UserDetailsController */
/* @var $model AUserDetails */

$this->breadcrumbs=array(
	'Auser Details'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List AUserDetails', 'url'=>array('index')),
	array('label'=>'Create AUserDetails', 'url'=>array('create')),
	array('label'=>'Update AUserDetails', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete AUserDetails', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage AUserDetails', 'url'=>array('admin')),
);
?>

<!--h1>View AUserDetails #<?php echo $model->id; ?></h1-->

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'first_name',
		'last_name',
	),
)); ?>
