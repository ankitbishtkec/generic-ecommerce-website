<?php
/* @var $this AddressController */
/* @var $model AAddress */


$this->pageTitle=Yii::app()->name . ' - Add Address';
$this->breadcrumbs=array(
	'Address',
);
?>

<?php $this->renderPartial('_form', array('model'=>$model, 'locality_array'=>$locality_array,)); ?>