<?php
/* @var $this UserDetailsController */
/* @var $model AUserDetails */

$this->breadcrumbs=array(
	'Auser Details'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List AUserDetails', 'url'=>array('index')),
	array('label'=>'Manage AUserDetails', 'url'=>array('admin')),
);
?>

<h1>Create AUserDetails</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>