<?php
/* @var $this OrderController */
/* @var $model AOrder */

$this->breadcrumbs=array(
	'Aorders'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List AOrder', 'url'=>array('index')),
	array('label'=>'Manage AOrder', 'url'=>array('admin')),
);
?>

<h1>Create AOrder</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>