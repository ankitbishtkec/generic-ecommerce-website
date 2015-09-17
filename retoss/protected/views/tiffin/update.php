<?php
/* @var $this TiffinController */
/* @var $model ATiffin */

$this->breadcrumbs=array(
	'Atiffins'=>array('index'),
	$model->name=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List ATiffin', 'url'=>array('index')),
	array('label'=>'Create ATiffin', 'url'=>array('create')),
	array('label'=>'View ATiffin', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage ATiffin', 'url'=>array('admin')),
);
?>

<h1>Update ATiffin <?php echo $model->id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>