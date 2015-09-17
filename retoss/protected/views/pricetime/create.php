<?php
/* @var $this PriceTimeController */
/* @var $model APriceTime */

$this->breadcrumbs=array(
	'Aprice Times'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List APriceTime', 'url'=>array('index')),
	array('label'=>'Manage APriceTime', 'url'=>array('admin')),
);
?>

<h1>Create APriceTime</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>