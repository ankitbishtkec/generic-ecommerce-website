<?php
/* @var $this SiteController */
/* @var $model ContactForm */
/* @var $form TbActiveForm */

$this->pageTitle=Yii::app()->name . ' - Contact Us';
$this->breadcrumbs=array(
	'Contact',
);
?>

<?php if(Yii::app()->user->hasFlash('contact')): ?>

    <?php $this->widget('bootstrap.widgets.TbAlert', array(
        'alerts'=>array('contact'),
    )); ?>

<?php else: ?>


<h3><i>If you have any questions, please fill out the following form to contact us. Thank you.</i></h3>

<div class="form">

<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm', array(
	'id'=>'contact-form',
    'type'=>'horizontal',
	'enableClientValidation'=>true,
	'clientOptions'=>array(
		'validateOnSubmit'=>true,
	),
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>
	
	<div class="row">
	<div class="col-sm-4 col-xs-10 col-xs-offset-1 col-sm-offset-0">
	<?php echo $form->errorSummary($model); ?>
	</div>
	</div>
	
	<div class="row form-group">
	<div class="col-sm-4 col-xs-10 col-xs-offset-1 col-sm-offset-0">
	<?php echo $form->labelEx($model,'name'); ?>
	<?php echo $form->textField($model,'name', array('class'=>'form-control input-sm') ); ?>
	<?php echo $form->error($model,'name', array(), false, true); ?>
	</div>
	</div>
	
	<div class="row form-group">
	<div class="col-sm-4 col-xs-10 col-xs-offset-1 col-sm-offset-0">
	<?php echo $form->labelEx($model,'email'); ?>
	<?php echo $form->textField($model,'email', array('class'=>'form-control input-sm') ); ?>
	<?php echo $form->error($model,'email', array(), false, true); ?>
	</div>
	</div>
	
	<div class="row form-group">
	<div class="col-sm-4 col-xs-10 col-xs-offset-1 col-sm-offset-0">
	<?php echo $form->labelEx($model,'subject'); ?>
	<?php echo $form->textField($model,'subject', array('class'=>'form-control input-sm', 'size'=>60,'maxlength'=>128) ); ?>
	<?php echo $form->error($model,'subject', array(), false, true); ?>
	</div>
	</div>
	
	<div class="row form-group">
	<div class="col-sm-4 col-xs-10 col-xs-offset-1 col-sm-offset-0">
	<?php echo $form->labelEx($model,'body'); ?>
	<?php echo $form->textArea($model,'body', array('class'=>'form-control input-sm', 'rows'=>6,) ); ?>
	<?php echo $form->error($model,'body', array(), false, true); ?>
	</div>
	</div>

	<?php if(CCaptcha::checkRequirements()): ?>
	<div class="row form-group">
	<div class="col-sm-4 col-xs-10 col-xs-offset-1 col-sm-offset-0">
		<?php echo $form->labelEx($model,'verifyCode'); ?>
		<br>
		<?php $this->widget('CCaptcha'); ?>
		<?php echo $form->textField($model,'verifyCode', array('class'=>'form-control input-sm') ); ?>
		<?php echo $form->error($model,'verifyCode', array(), false, true); ?>
		
		<p class="hint"><?php echo "Please enter the letters as they are shown in the image above."; ?>
		<br/><?php echo "Letters are not case-sensitive."; ?></p>
	</div>
	</div>
	<?php endif; ?>
	
	<div class="row">
	<div class="col-sm-2 col-xs-2 col-xs-offset-1 col-sm-offset-0">
		<?php echo CHtml::submitButton("Submit", array('class'=>'btn btn-primary  btn-sm',)); ?>
	</div>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->

<?php endif; ?>