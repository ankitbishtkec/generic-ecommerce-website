<?php
/* @var $this CartController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Acarts',
);

$this->menu=array(
	array('label'=>'Create ACart', 'url'=>array('create')),
	array('label'=>'Manage ACart', 'url'=>array('admin')),
);
?>

<h1>Acarts</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
