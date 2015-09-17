<?php
/* @var $this CartController */
/* @var $model CheckoutSecondStageForm */
/* @var $form CActiveForm  */

$this->pageTitle=Yii::app()->name . ' - Checkout';
$this->breadcrumbs=array();
?>

<h3><i>Secure Checkout- Enter payment information</i></h3>

<div class="form">

<?php
	//js script and file handling -start
	$cs = Yii::app()->getClientScript();
	$path = Yii::app()->getBasePath().'/jsFiles/';
	Yii::app()->assetManager->publish($path, true, -1, false);
	$path1 =  Yii::app()->assetManager->getPublishedUrl(  $path );
	$cs->registerScriptFile( $path1.'/checkoutSecondStage.js');
	Yii::app()->clientScript->registerScript(__CLASS__.'#'."a","initializePage();");
	//js script and file handling -stop
	
	$goBackLink = Yii::app()->getRequest()->getHostInfo().Yii::app()->getRequest()->getScriptUrl().
		'/cart/checkout/id/'.$model->encryptedOrderId;
	$form=$this->beginWidget('bootstrap.widgets.TbActiveForm', array(
	'id'=>'CheckoutSecondStage-form',
    //'type'=>'inline',
	'action'=>$goBackLink,
	'enableClientValidation'=>true,
	'clientOptions'=>array(
		'validateOnSubmit'=>true,
	),
    )
	);
?>
	<hr noshade>
	<div class="row">
	<div class="col-sm-9 col-xs-10 col-xs-offset-1 col-sm-offset-0">
	<a href=<?php echo "'".$goBackLink."'"; ?> ><button type="button" class="btn btn-danger  btn-sm">previous screen</button></a>
	<i >Kindly do not press "Back", "Forward" or "Refresh" button of browser on this screen.</i>
	</div>
	</div>
	<hr noshade>

	<div class="row">
	<div class="col-sm-9 col-xs-10 col-xs-offset-1 col-sm-offset-0">
	<?php echo $form->errorSummary($model);?>
	</div>
	</div>
	
<div id="inputgroup">
		
	<div class="row form-group">
	<div class="col-sm-9 col-xs-10 col-xs-offset-1 col-sm-offset-0">
		<label class="required">Select delivery time( for each item ) <span class="required">*</span></label>
		<?php 
			$this->renderPartial('tiffin_pricetime_selection_table', array(
				'modelArr'=>$model->tiffinPriceTimeSelectionArr,
				'form'=>$form,
				'goBackLink'=>$goBackLink,
				), false, false);
		?>
	</div>
	</div>
	
	<div class="row form-group">
	<div class="col-sm-4 col-xs-10 col-xs-offset-1 col-sm-offset-0">
	<?php 
		echo $form->labelEx($model,'amountUsedFromWallet');
		echo $form->textField($model,'amountUsedFromWallet', array('class'=>'form-control input-sm', 'data-wallet'=>$model->totalAmountInWallet,) );
		echo $form->error($model,'amountUsedFromWallet', array(), false, true); 
		echo '<p style="font-size: 80%;">Amount available in wallet is <span style="color:red;"><b><i class="fa fa-inr"></i> '.$model->totalAmountInWallet.'</b></span></p>'
	?>
	</div>
	</div>
	
	<div class="row form-group">
	<div class="col-sm-4 col-xs-10 col-xs-offset-1 col-sm-offset-0">
	<?php echo $form->labelEx($model, 'paymentMethod');?>
	<div class="row" id="wallet">
		<div class="col-xs-1">
			<?php echo CHtml::activeRadioButton( $model, 'paymentMethod',array( 'value'=>1, 'required'=> true, 
				'uncheckValue'=> NULL, 'float'=>'left', ) );?>
		</div>
		<div class="col-xs-10">
			<p>tw.in wallet</p>
		</div>
	</div>
	<div class="row" id="onlinepayment" style="display: none;">
		<div class="col-xs-1">
			<?php echo CHtml::activeRadioButton( $model, 'paymentMethod',array( 'value'=>2, 'required'=> true, 
				'uncheckValue'=> NULL, 'float'=>'left', ) );?>
		</div>
		<div class="col-xs-10">
			<p>Online payment PayU Money</p>
		</div>
	</div>
	<div class="row" id="cod">
		<div class="col-xs-1">
			<?php echo CHtml::activeRadioButton( $model, 'paymentMethod',array( 'value'=>3, 'required'=> true, 
				'uncheckValue'=> NULL, 'float'=>'left', ) );?>
		</div>
		<div class="col-xs-10">
			<p>Cash on delivery</p>
		</div>
	</div>
	<?php echo $form->error($model,'paymentMethod', array(), false, false);//client validation made false due to radio button?>
	</div>
	</div>
	
</div>
	
	<!--div class="row form-group">
	<div class="col-sm-4 col-xs-10 col-xs-offset-1 col-sm-offset-0">
	<?php echo $form->labelEx($model,'couponCode');?>
	<div class="row">
		<div class="col-xs-9">
			<?php echo $form->textField($model,'couponCode', array('class'=>'form-control input-sm',) );?>
		</div>
		<div class="col-xs-3">
			<button type="button" class="btn btn-success  btn-sm" id='verify'>Verify</button>
		</div>
	</div>
	<?php echo $form->error($model,'couponCode', array(), false, true);?>
	</div>
	</div-->
	
	
	<div class="row">
	<div class="col-sm-2 col-xs-2 col-xs-offset-1 col-sm-offset-0">
		<?php echo CHtml::submitButton(CHtml::encode("Confirm order"), array('class'=>'btn btn-primary  btn-sm',)); ?>
	</div>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->