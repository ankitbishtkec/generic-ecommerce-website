<?php
/* @var $this SiteController */
/* @var $model ContactForm */
/* @var $form TbActiveForm */

$this->pageTitle=Yii::app()->name . ' - Quick Buy';
$this->breadcrumbs=array(
	'Contact',
);
?>

<?php if(Yii::app()->user->hasFlash('buy')): ?>

    <?php $this->widget('bootstrap.widgets.TbAlert', array(
        'alerts'=>array('buy'),
    )); ?>

<?php else: ?>


<h3><i>Please fill out the following form to order a tiffin. Thank you.</i></h3>

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
	
	<div class="row">
	<div class="col-sm-4 col-xs-10 col-xs-offset-1 col-sm-offset-0">
	<div class='wordwrap'>
        <b style="font-size: 140%;"><?php echo CHtml::encode($data->name); ?></b><br>
        <i style="font-size: 140%;color: #ff0000"><?php echo CHtml::encode($data->contents); ?></i><br>        
        <div class="well wordwrap" style="padding: 5px; overflow:auto; height: 132px; margin-top: 5px; margin-bottom: 0px;
        border-bottom-right-radius: 0px; border-bottom-left-radius: 0px;">
        	

        	<b>Order before - </b><?php
        		$temp_date1 = DateTime::createFromFormat('Y-m-d H:i:s', $data->aPriceTimes[0]->order_end_time);
				if( $temp_date1 !=FALSE)
				{
        			echo($temp_date1->format('Y-M-d l, h:i:s a'));
        		}
        	 ?>
        	<br>
        	<b>Delivery around - </b><?php
        		$temp_date = DateTime::createFromFormat('Y-m-d H:i:s', $data->aPriceTimes[0]->order_delivery_time);
				if( $temp_date !=FALSE)
				{
        			echo($temp_date->format('Y-M-d l, h:i:s a'));
        		}
        	 ?>
        	<br>
        	<i class="fa fa-inr"></i><?php echo CHtml::encode("  ".$data->aPriceTimes[0]->price_after_discount).' /-'; ?>
        	<?php echo '<span class="label label-danger" style="margin-right: 2px;display: inline-block;">'.CHtml::encode( " - ".$data->aPriceTimes[0]->discount."% applied" ).'</span>';?>
        </div>
    </div>
	</div>
	</div>
	
	<div class="row form-group">
	<div class="col-sm-4 col-xs-10 col-xs-offset-1 col-sm-offset-0">
	<?php echo $form->labelEx($model,'quantity'); ?>
	<?php echo $form->textField($model,'quantity', array('class'=>'form-control input-sm', 'size'=>60,'maxlength'=>128) ); ?>
	<?php echo $form->error($model,'quantity', array(), false, true); ?>
	</div>
	</div>
	
	
	<!--div class="row form-group">
	<div class="col-xs-12 col-sm-4">
	<?php echo $form->labelEx($model,'name'); ?>
	<?php echo $form->textField($model,'name', array('class'=>'form-control input-sm') ); ?>
	<?php echo $form->error($model,'name', array(), false, true); ?>
	</div>
	</div-->
	
	<!--div class="row form-group">
	<div class="col-xs-12 col-sm-4">
	<?php echo $form->labelEx($model,'email'); ?>
	<?php echo $form->textField($model,'email', array('class'=>'form-control input-sm') ); ?>
	<?php echo $form->error($model,'email', array(), false, true); ?>
	</div>
	</div-->
	
	
	<div class="row form-group">
	<div class="col-sm-4 col-xs-10 col-xs-offset-1 col-sm-offset-0">
	<?php echo $form->labelEx($model,'phone'); ?>
	<?php echo $form->textField($model,'phone', array('class'=>'form-control input-sm') ); ?>
	<?php echo $form->error($model,'phone', array(), false, true); ?>
	</div>
	</div>
	
	<div class="row form-group">
	<div class="col-sm-4 col-xs-10 col-xs-offset-1 col-sm-offset-0">
	<?php echo $form->labelEx($model,'techpark'); ?>
	<?php echo $form->textField($model,'techpark', array('class'=>'form-control input-sm') ); ?>
	<?php echo $form->error($model,'techpark', array(), false, true); ?>
	</div>
	</div>
	
	<div class="row form-group">
	<div class="col-sm-4 col-xs-10 col-xs-offset-1 col-sm-offset-0">
	<?php echo $form->labelEx($model,'address'); ?>
	<?php echo $form->textArea($model,'address', array('class'=>'form-control input-sm', 'rows'=>6,) ); ?>
	<?php echo $form->error($model,'address', array(), false, true); ?>
	</div>
	</div>
	
	<div class="row form-group">
	<div class="col-sm-4 col-xs-10 col-xs-offset-1 col-sm-offset-0">
	<?php echo $form->labelEx($model,'paymentMode'); ?>
	<?php echo "<br>"; ?>
	<?php echo $form->radioButtonList($model,'paymentMode',
	array('SODEXO ON DELIVERY'=>'SODEXO on delivery','CASH ON DELIVERY'=>'CASH on delivery'),
	array( 'required' => true ,'uncheckValue'=> NULL,) ); ?>
	<?php echo "<br>"; ?>
	<?php echo $form->error($model,'paymentMode', array(), false, true); ?>
	</div>
	</div>


	<div class="row">
	<div class="col-xs-offset-1 col-xs-5 col-sm-2 col-sm-offset-0">
		<?php echo CHtml::submitButton("Click to order", array('class'=>'btn btn-primary  btn-sm',)); ?>
	</div>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->

<?php endif; ?>