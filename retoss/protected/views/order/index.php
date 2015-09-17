<?php
/* @var $this OrderController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Aorders',
);

$this->menu=array(
	array('label'=>'Create AOrder', 'url'=>array('create')),
	array('label'=>'Manage AOrder', 'url'=>array('admin')),
);
?>

<h1>Aorders</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
