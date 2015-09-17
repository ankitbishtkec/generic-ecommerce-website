<?php
/* @var $this CartController */
/* @var $modelArr array() */
/* @var $form CActiveForm  */
/* @var $goBackLink  */
?>

	<table class="table table-condensed" id="delivrytimeselecttable" style="table-layout: fixed;">
	<tbody>
		<tr>
			<th class="wordwrap" style="width: 40%;">Item</th>
			<th class="wordwrap" style="width: 10%;">Qty</th>
			<th class="wordwrap" style="width: 35%;">Delivery Time</th>
			<!--th class="wordwrap" style="width: 15%;">Subtotal</th-->
		</tr>
	
	<?php
	/* @var $row TiffinPriceTimeSelectionForm */
	foreach ( $modelArr as $key => $row) 
	{
		$tiffinObj = $row->aOrderObj->order2tiffin0;
		if( isset( $tiffinObj->image ) )
			$imagePath = AppCommon::getAppFolderUrl().'/images/tiffin_images/'.$tiffinObj->image;
		else
			$imagePath = AppCommon::getAppFolderUrl().'/images/tiffin_images/5.jpg';//default image
		
		
		echo '<tr>';
		
		echo '<td>';
		echo '<a target="_blank" href="'.AppCommon::getSiteBaseUrl().'/tiffin/view/id/'.$tiffinObj->name.'-'.$tiffinObj->id.'">'.
			'<img src="'.$imagePath.'" alt="Loading..." style="width: 70px; float: left; height: 70px; margin-right: 5px; margin-bottom: 5px;"></a>'.
			'<b>'.$tiffinObj->name.'</b>'.
			'<p style="font-size: 80%;">'.$tiffinObj->contents.'</p>';
		echo '</td>';
		
		echo '<td>';
		echo $row->quantity;
		echo '<br>';
		echo '<a style="color:red;" href="'.$goBackLink.'"><u>Edit</u></a>';
		echo '</td>';
		
		echo '<td>';
		
		echo '<table class="table-condensed" style="table-layout: fixed;">';
		echo '<tbody>';
		/* @var $value APriceTime */
		foreach ( $row->allowedAPriceTimeObjArray as $value ) 
		{
			echo '<tr>';
			
			echo '<td>';
			
			echo CHtml::activeRadioButton( $row, '['.$key.']selectedPriceTimeId',array( 'value'=>$value->id, 'required'=> true, 
				'data-perunitprice'=>$value->price_after_discount, 'data-quantity'=>$row->quantity, 'uncheckValue'=> NULL, 'float'=>'left', ) );
				
			echo '</td>';
			
			echo '<td>';
			
			echo '<p style="font-size: 80%;"><span style="color:blue;"><b>'.AppCommon::getDetailedDateString( $value->order_delivery_time ).
				'</b></span> at <span style="color:red;"><b><i class="fa fa-inr"></i> '.' '.$value->price_after_discount.'</b></span> per item'.'</p>';
				
			echo '</td>';
			
			echo '</tr>';
		}
		echo '</tbody>';
		echo '</table>';
		
		echo $form->error($row, '['.$key.']selectedPriceTimeId', array(), false, false);//client validation made false due to radio button
		echo '</td>';
		
		//echo '<td>';
		//echo '<b><i class="fa fa-inr"></i> '.' '.$row->totalPrice.' </b>';
		//echo '</td>';
		
		echo '</tr>';
		}
		?>
	
	</tbody>
	</table>