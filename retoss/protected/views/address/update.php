<?php
/* @var $this AddressController */
/* @var $model AAddress */

$this->breadcrumbs=array(
	'Aaddresses'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List AAddress', 'url'=>array('index')),
	array('label'=>'Create AAddress', 'url'=>array('create')),
	array('label'=>'View AAddress', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage AAddress', 'url'=>array('admin')),
);
?>

<h1>Update AAddress <?php echo $model->id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>