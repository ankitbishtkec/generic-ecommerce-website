<?php
/* @var $this UserDetailsController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Auser Details',
);

$this->menu=array(
	array('label'=>'Create AUserDetails', 'url'=>array('create')),
	array('label'=>'Manage AUserDetails', 'url'=>array('admin')),
);
?>

<h1>Auser Details</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
