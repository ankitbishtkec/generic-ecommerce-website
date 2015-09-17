<?php
/* @var $this PriceTimeController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Aprice Times',
);

$this->menu=array(
	array('label'=>'Create APriceTime', 'url'=>array('create')),
	array('label'=>'Manage APriceTime', 'url'=>array('admin')),
);
?>

<h1>Aprice Times</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
