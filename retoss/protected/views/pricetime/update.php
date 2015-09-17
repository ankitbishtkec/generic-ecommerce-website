<?php
/* @var $this PriceTimeController */
/* @var $model APriceTime */

$this->breadcrumbs=array(
	'Aprice Times'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List APriceTime', 'url'=>array('index')),
	array('label'=>'Create APriceTime', 'url'=>array('create')),
	array('label'=>'View APriceTime', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage APriceTime', 'url'=>array('admin')),
);
?>

<h1>Update APriceTime <?php echo $model->id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>