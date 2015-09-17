<?php
/* @var $this TiffinController */
/* @var $model ATiffin */

$this->breadcrumbs=array(
	'Atiffins'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List ATiffin', 'url'=>array('index')),
	array('label'=>'Manage ATiffin', 'url'=>array('admin')),
);
?>

<h3>Create Tiffin</h3>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>