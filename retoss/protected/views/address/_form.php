<?php
/* @var $this AddressController */
/* @var $model AAddress */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm', array(
	'id'=>'address-form',
    'type'=>'horizontal',
	'enableClientValidation'=>true,
	'clientOptions'=>array(
		'validateOnSubmit'=>true,
	),
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<!--div class="row">
	<div class="col-xs-10 col-xs-offset-1">
	<?php echo $form->errorSummary($model); ?>
	</div>
	</div-->
	
	<div class="row form-group">
	<div class="col-xs-10 col-xs-offset-1">
		<?php echo $form->labelEx($model,'address2bangalore_localities'); ?>
		<?php echo CHtml::activeDropDownList($model,'address2bangalore_localities', $locality_array,array( 'style'=>'font-size:15px;margin-bottom: 5px;',
		'class'=>'form-control input-sm', 'options'=>array(''=>array('hidden'=>true,) ) ) ); ?>
		<?php echo $form->error($model,'address2bangalore_localities'); ?>
	</div>
	</div>

	<!--div class="row form-group">
	<div class="col-sm-4 col-xs-10 col-xs-offset-1 col-sm-offset-0">
		<?php echo $form->labelEx($model,'house_flat_num'); ?>
		<?php echo $form->textField($model,'house_flat_num',array('size'=>10,'maxlength'=>10, 'class'=>'form-control input-sm',)); ?>
		<?php echo $form->error($model,'house_flat_num'); ?>
	</div>
	</div>

	<div class="row form-group">
	<div class="col-sm-4 col-xs-10 col-xs-offset-1 col-sm-offset-0">
		<?php echo $form->labelEx($model,'society_apartment_name'); ?>
		<?php echo $form->textField($model,'society_apartment_name',array('size'=>50,'maxlength'=>50, 'class'=>'form-control input-sm',)); ?>
		<?php echo $form->error($model,'society_apartment_name'); ?>
	</div>
	</div-->

	<div class="row form-group">
	<div class="col-xs-10 col-xs-offset-1">
		<?php echo $form->labelEx($model,'street_name1'); ?>
		<?php echo $form->textField($model,'street_name1',array('size'=>100,'maxlength'=>100, 'class'=>'form-control input-sm',)); ?>
		<?php echo $form->error($model,'street_name1'); ?>
	</div>
	</div>

	<div class="row form-group">
	<div class="col-xs-10 col-xs-offset-1">
		<?php echo $form->labelEx($model,'street_name2'); ?>
		<?php echo $form->textField($model,'street_name2',array('size'=>100,'maxlength'=>100, 'class'=>'form-control input-sm',)); ?>
		<?php echo $form->error($model,'street_name2'); ?>
	</div>
	</div>

	<!--div class="row form-group">
	<div class="col-sm-4 col-xs-10 col-xs-offset-1 col-sm-offset-0">
		<?php echo $form->labelEx($model,'locality'); ?>
		<?php echo $form->textField($model,'locality',array('size'=>100,'maxlength'=>100, 'class'=>'form-control input-sm',)); ?>
		<?php echo $form->error($model,'locality'); ?>
	</div>
	</div-->

	<div class="row form-group">
	<div class="col-xs-10 col-xs-offset-1">
		<?php echo $form->labelEx($model,'landmark'); ?>
		<?php echo $form->textField($model,'landmark',array('size'=>100,'maxlength'=>100, 'class'=>'form-control input-sm',)); ?>
		<?php echo $form->error($model,'landmark'); ?>
	</div>
	</div>

	<div class="row form-group">
	<div class="col-xs-10 col-xs-offset-1">
		<?php echo $form->labelEx($model,'city'); ?>
		<?php echo $form->textField($model,'city',array('size'=>50,'maxlength'=>50, 'class'=>'form-control input-sm',)); ?>
		<?php echo $form->error($model,'city'); ?>
	</div>
	</div>

	<!--div class="row form-group">
	<div class="col-sm-4 col-xs-10 col-xs-offset-1 col-sm-offset-0">
		<?php echo $form->labelEx($model,'pin'); ?>
		<?php echo $form->textField($model,'pin', array( 'class'=>'form-control input-sm',)); ?>
		<?php echo $form->error($model,'pin'); ?>
	</div>
	</div-->

	<div class="row">
	<div class="col-xs-10 col-xs-offset-1">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Add' : 'Save', array('class'=>'btn btn-primary  btn-sm',
		'id'=>'addAddressButton',)); ?>
	</div>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->