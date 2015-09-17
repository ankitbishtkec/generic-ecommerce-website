<?php
/* @var $this OrderController */
/* @var $model AOrder */

$this->breadcrumbs=array(
	'Aorders'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List AOrder', 'url'=>array('index')),
	array('label'=>'Create AOrder', 'url'=>array('create')),
	array('label'=>'View AOrder', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage AOrder', 'url'=>array('admin')),
);
?>

<h1>Update AOrder <?php echo $model->id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>