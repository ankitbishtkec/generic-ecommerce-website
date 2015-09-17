<?php
/* @var $this CartController */
/* @var $model CheckoutFirstStageForm */
/* @var $form CActiveForm  */

$this->pageTitle=Yii::app()->name . ' - Checkout';
$this->breadcrumbs=array();
?>

<h3><i>Secure Checkout- Enter delivery information</i></h3>

<div class="form">

<?php
	//js script and file handling -start
	$cs = Yii::app()->getClientScript();
	$path = Yii::app()->getBasePath().'/jsFiles/';
	Yii::app()->assetManager->publish($path, true, -1, false);
	$path1 =  Yii::app()->assetManager->getPublishedUrl(  $path );
	$cs->registerScriptFile( $path1.'/checkoutFirstStage.js');
	$cs->registerScriptFile( $path1.'/addAddress.js');
	Yii::app()->clientScript->registerScript(__CLASS__.'#'."a","initializePage();");
	Yii::app()->clientScript->registerScript(__CLASS__.'#'."a1","showCartOnPageLoad();");
	//js script and file handling -stop
	
	$form=$this->beginWidget('bootstrap.widgets.TbActiveForm', array(
	'id'=>'CheckoutFirstStage-form',
    //'type'=>'inline',
	'enableClientValidation'=>true,
	'clientOptions'=>array(
		'validateOnSubmit'=>true,
	),
    )
	);
	echo $form->hiddenField( $model,'customerLocality',
	 array('id'=> 'selected_locality', ));//hidden field for user selected locality added here
?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<div class="row">
	<div class="col-sm-9 col-xs-10 col-xs-offset-1 col-sm-offset-0">
	<?php echo $form->errorSummary($model); ?>
	</div>
	</div>
	
	<div class="row form-group">
	<div class="col-sm-9 col-xs-10 col-xs-offset-1 col-sm-offset-0">
	<?php echo $form->labelEx($model,'address'); ?>
	<table class="table table-condensed table-striped" id="addressTable" style="table-layout: fixed;">
	<tbody>
	
	<tr>
		<th class="wordwrap" style="width: 10%;">Select</th>
		<th class="wordwrap" style="width: 60%;">Address</th>
		<th class="wordwrap" style="width: 30%;">Locality</th>
	</tr>
	
	<?php
	//array( addrId => array( locality, addrText ) )
	foreach ( $addressArray as $key => $value) 
	{
		echo '<tr>';
		
		echo '<td>';
		echo CHtml::activeRadioButton($model,'address',array( 'value'=>$key, 'required'=> true, 
		'data-locality_name'=>$value[ 0 ], 'uncheckValue'=> NULL, ) );
		echo '</td>';
		
		echo '<td>';
		echo $value[ 1 ];
		echo '</td>';
		
		echo '<td>';
		echo $value[ 0 ];
		echo '</td>';
		
		echo '</tr>';
	}
	?>
	
	</tbody>
	</table>
	<?php echo $form->error($model,'address', array(), false, false);//client validation made false due to radio button ?>
	<?php echo $form->error($model,'extraErrorMessages', array(), false, true); ?>
	<?php echo CHtml::button(CHtml::encode("Add new address"), array('class'=>'btn btn-success  btn-sm',
	'id'=>'addAddressInCheckoutScreen',)); ?>
	
	</div>
	</div>
	
	<div class="row form-group">
	<div class="col-sm-6 col-xs-10 col-xs-offset-1 col-sm-offset-0">
	<div id="cartTable">
	<?php Yii::app()->getClientScript()->registerScript(__CLASS__.'#'."main2", 
"initializeLayout();"); ?>
		<!--here cart items will be shown using JS-->
		<!--currently this div is not being used-->
	</div>
	<!--?php echo $form->error($model,'extraErrorMessages', array(), false, true); ?-->
	</div>
	</div>
	
	<div class="row form-group">
	<div class="col-sm-4 col-xs-10 col-xs-offset-1 col-sm-offset-0">
	<?php echo $form->labelEx($model,'phone'); ?>
	<?php echo $form->textField($model,'phone', array('class'=>'form-control input-sm') ); ?>
	<?php echo $form->error($model,'phone', array(), false, true); ?>
	</div>
	</div>
	
	<div class="row">
	<div class="col-sm-2 col-xs-2 col-xs-offset-1 col-sm-offset-0">
		<?php echo CHtml::submitButton(CHtml::encode("Proceed to payment"), array('class'=>'btn btn-primary  btn-sm',)); ?>
	</div>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->