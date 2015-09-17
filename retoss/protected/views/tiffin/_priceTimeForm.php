<?php
	echo "<tr id='pricetimerow".$index."'>";
?>
	<td>	
		<br>
		<?php 
			$this->widget('ext.YiiDateTimePicker.jqueryDateTime', array(
        		'model' => $model,
        		'attribute' => '['.$index.']order_start_time',
        		'options' => array(
						'format'=>'Y-m-d H:i:00',
						'timepicker'=>true,
						'minDate'=>$today,
					), //DateTimePicker options
        		'htmlOptions' => array(
							'autocomplete'=>"off",'required'=>1
				),
    		));	
			
			$this->widget('ext.YiiDateTimePicker.jqueryDateTime', array(
        		'model' => $model,
        		'attribute' => '['.$index.']order_end_time',
        		'options' => array(
						'format'=>'Y-m-d H:i:00',
						'timepicker'=>true,
						'minDate'=>$today,
					), //DateTimePicker options
        		'htmlOptions' => array(
							'autocomplete'=>"off",'required'=>1
				),
    		));	
			
			$this->widget('ext.YiiDateTimePicker.jqueryDateTime', array(
        		'model' => $model,
        		'attribute' => '['.$index.']order_delivery_time',
        		'options' => array(
						'format'=>'Y-m-d H:i:00',
						'timepicker'=>true,
						'minDate'=>$today,
					), //DateTimePicker options
        		'htmlOptions' => array(
							'autocomplete'=>"off",'required'=>1
				),
    		));	
		?>
	</td>

	<td>
		<?php 
			echo CHtml::activeNumberField($model,'['.$index.']price_after_discount',array('min'=>0
				,'required'=>1));
			echo CHtml::activeNumberField($model,'['.$index.']discount',array('min'=>0
				,'max'=>100,'required'=>1)); 
		?>
	</td>

	<td>
		<?php echo CHtml::activeNumberField($model,'['.$index.']initial_quantity',array('min'=>1,'required'=>1)); ?>
	</td>

	<td>
		<?php 
		echo CHtml::activeTextField($model,'['.$index.']verified_by',array('size'=>10,'maxlength'=>10, 'readonly'=>1));
		echo CHtml::htmlButton('Delete',$htmlOptions=array(
		'class'=>'deletebutton',
		'data-rowid'=>'pricetimerow'.$index,
		)); 
		?>
	</td>
</tr>
