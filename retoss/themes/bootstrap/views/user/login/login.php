<?php
/* @var $this SiteController */
/* @var $model LoginForm */
/* @var $form CActiveForm  */

$this->pageTitle=Yii::app()->name . ' - Login';
$this->breadcrumbs=array(
	'Login',
);
?>

<h3><i>Login</i></h3>

<div class="form">

<?php
	$hr = Yii::app()->getRequest();
	$actionUrl = $hr->getScriptUrl().Yii::app()->controller->module->loginUrl[0];
	$form=$this->beginWidget('bootstrap.widgets.TbActiveForm', array(
	'id'=>'login-form',
    //'type'=>'inline',
	'enableClientValidation'=>true,
	//'enableAjaxValidation'=>true,
	'clientOptions'=>array(
		'validateOnSubmit'=>true,
	),
	'action'=>$actionUrl,
)); ?>
	
	<div class="row form-group">
	<div class="col-sm-4 col-xs-10 col-xs-offset-1 col-sm-offset-0">
	<?php echo $form->labelEx($model,'username'); ?>
	<?php echo $form->textField($model,'username', array('class'=>'form-control input-sm') ); ?>
	<?php echo $form->error($model,'username', array(), false, true); ?>
	</div>
	</div>
	
	<div class="row form-group">
	<div class="col-sm-4 col-xs-10 col-xs-offset-1 col-sm-offset-0">
	<?php echo $form->labelEx($model,'password'); ?>
	<?php echo $form->passwordField($model,'password', array('class'=>'form-control input-sm') ); ?>
	<?php echo $form->error($model,'password', array(), false, true); ?>
	</div>
	</div>
	
	<div class="row checkbox">
	<div class="col-sm-4 col-xs-10 col-xs-offset-1 col-sm-offset-0">
	<?php echo $form->checkBoxRow($model,'rememberMe'); ?>
	</div>
	</div>
	
	<div class="row ">
	<div class="col-sm-4 col-xs-10 col-xs-offset-1 col-sm-offset-0">
		<p class="hint">
		<?php echo CHtml::link(UserModule::t("Register"),Yii::app()->getModule('user')->registrationUrl); ?> | <?php echo CHtml::link(UserModule::t("Lost Password?"),Yii::app()->getModule('user')->recoveryUrl); ?>
		</p>
	</div>
	</div>
	
	<div class="row">
	<div class="col-sm-2 col-xs-2 col-xs-offset-1 col-sm-offset-0">
		<?php echo CHtml::submitButton(UserModule::t("Login"), array('class'=>'btn btn-primary  btn-sm',)); ?>
	</div>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->