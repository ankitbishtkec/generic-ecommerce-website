<?php
/* @var $this UserDetailsController */
/* @var $model AUserDetails */

$this->breadcrumbs=array(
	'Auser Details'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List AUserDetails', 'url'=>array('index')),
	array('label'=>'Create AUserDetails', 'url'=>array('create')),
	array('label'=>'View AUserDetails', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage AUserDetails', 'url'=>array('admin')),
);
?>

<h1>Update AUserDetails <?php echo $model->id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>