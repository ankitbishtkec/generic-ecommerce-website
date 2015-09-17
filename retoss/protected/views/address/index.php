<?php
/* @var $this AddressController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Aaddresses',
);

$this->menu=array(
	array('label'=>'Create AAddress', 'url'=>array('create')),
	array('label'=>'Manage AAddress', 'url'=>array('admin')),
);
?>

<h1>Aaddresses</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
