<?php $this->pageTitle=Yii::app()->name . ' - '.UserModule::t("Restore");
$this->breadcrumbs=array(
	UserModule::t("Login") => array('/user/login'),
	UserModule::t("Restore"),
);
?>

<h3><i>Restore</i></h3>

<?php if(Yii::app()->user->hasFlash('recoveryMessage')): ?>
<div class="success">
<?php echo Yii::app()->user->getFlash('recoveryMessage'); ?>
</div>
<?php else: ?>

<div class="form">
<?php echo CHtml::beginForm(); ?>

	<?php echo CHtml::errorSummary($form); ?>
	
	<div class="row form-group">
	<div class="col-sm-4 col-xs-10 col-xs-offset-1 col-sm-offset-0">
		<?php echo CHtml::activeLabel($form,'login_or_email'); ?>
		<?php echo CHtml::activeTextField($form,'login_or_email', array('class'=>'form-control input-sm') ) ?>
		<p class="hint"><?php echo UserModule::t("Please enter your login or email addres."); ?></p>
	</div>
	</div>
		
	<div class="row submit">
	<div class="col-sm-2 col-xs-2 col-xs-offset-1 col-sm-offset-0">
		<?php echo CHtml::submitButton(UserModule::t("Restore"), array('class'=>'btn btn-primary  btn-sm',)); ?>
	</div>
	</div>

<?php echo CHtml::endForm(); ?>
</div><!-- form -->
<?php endif; ?>