<?php
/* @var $this UserDetailsController */
/* @var $model AUserDetails */

$this->breadcrumbs=array(
	'Auser Details'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>'List AUserDetails', 'url'=>array('index')),
	array('label'=>'Create AUserDetails', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#auser-details-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Manage Auser Details</h1>

<p>
You may optionally enter a comparison operator (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b>
or <b>=</b>) at the beginning of each of your search values to specify how the comparison should be done.
</p>

<?php echo CHtml::link('Advanced Search','#',array('class'=>'search-button')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'auser-details-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'id',
		'is_active',
		'user_type',
		'first_name',
		'last_name',
		'dob',
		/*
		'user_details2time_details',
		'person_details2photo',
		'person_details2address',
		'person_details2phone',
		'person_details2email',
		'expiry_date_of_tiffinwala',
		'rating_of_tiffinwala',
		'is_deleted',
		*/
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
