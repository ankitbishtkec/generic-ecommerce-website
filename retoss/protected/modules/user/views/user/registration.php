<?php $this->pageTitle=Yii::app()->name . ' - '.UserModule::t("Registration");

?>
<h3><i><?php echo UserModule::t("Registration"); ?></i></h3>

<?php if(Yii::app()->user->hasFlash('registration')): ?>
<div class="success">
<?php echo Yii::app()->user->getFlash('registration'); ?>
</div>
<?php else: ?>

<div class="form">
<?php
	//Ajax and client validation happens on cahnge of data but ajax validation only happens on email data change 
	$form=$this->beginWidget('bootstrap.widgets.TbActiveForm', array(
	'id'=>'registration-form',
	'enableAjaxValidation'=>true,
	'enableClientValidation'=>true,
	'errorMessageCssClass'=>'help-block error',
	'htmlOptions' => array('enctype'=>'multipart/form-data'),
)); ?>

	<p class="note"><?php echo UserModule::t('Fields with <span class="required">*</span> are required.'); ?></p>
	
	<div class="row">
	<div class="col-sm-4 col-xs-10 col-xs-offset-1 col-sm-offset-0">
	<?php echo $form->errorSummary( $model ); ?>
	</div>
	</div>
	
	<div class="row form-group">
	<div class="col-sm-4 col-xs-10 col-xs-offset-1 col-sm-offset-0">
	<?php echo $form->labelEx($model,'firstName'); ?>
	<?php echo $form->textField($model,'firstName', array('class'=>'form-control input-sm') ); ?>
	<?php echo $form->error($model,'firstName', array(), false, true); ?>
	</div>
	</div>
	
	<div class="row form-group">
	<div class="col-sm-4 col-xs-10 col-xs-offset-1 col-sm-offset-0">
	<?php echo $form->labelEx($model,'email'); ?>
	<?php echo $form->textField($model,'email', array('class'=>'form-control input-sm') ); ?>
	<?php echo $form->error($model,'email', array(), true, true); ?>
	</div>
	</div>
	
	<div class="row form-group">
	<div class="col-sm-4 col-xs-10 col-xs-offset-1 col-sm-offset-0">
	<?php echo $form->labelEx($model,'password'); ?>
	<?php echo $form->passwordField($model,'password', array('class'=>'form-control input-sm') ); ?>
	<?php echo $form->error($model,'password', array(), false, true); ?>
	</div>
	</div>
	
	<div class="row form-group">
	<div class="col-sm-4 col-xs-10 col-xs-offset-1 col-sm-offset-0">
	<?php echo $form->labelEx($model,'verifyPassword'); ?>
	<?php echo $form->passwordField($model,'verifyPassword', array('class'=>'form-control input-sm') ); ?>
	<?php echo $form->error($model,'verifyPassword', array(), false, true); ?>
	</div>
	</div>
	
	<!--<?php if (UserModule::doCaptcha('registration')): ?>
	<div class="row form-group">
	<div class="col-sm-4 col-xs-10 col-xs-offset-1 col-sm-offset-0">
		<?php echo $form->labelEx($model,'verifyCode'); ?>
		<br>
		<?php $this->widget('CCaptcha'); ?>
		<?php echo $form->textField($model,'verifyCode', array('class'=>'form-control input-sm') ); ?>
		<?php echo $form->error($model,'verifyCode', array(), false, true); ?>
		
		<p class="hint"><?php echo UserModule::t("Please enter the letters as they are shown in the image above."); ?>
		<br/><?php echo UserModule::t("Letters are not case-sensitive."); ?></p>
	</div>
	</div>
	<?php endif; ?>-->
	
	<div class="row">
	<div class="col-sm-2 col-xs-2 col-xs-offset-1 col-sm-offset-0">
		<?php echo CHtml::submitButton(UserModule::t("Register"), array('class'=>'btn btn-primary  btn-sm',)); ?>
	</div>
	</div>

<?php $this->endWidget(); ?>
</div><!-- form -->
<?php endif; ?>