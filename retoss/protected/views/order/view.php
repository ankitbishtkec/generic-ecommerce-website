<?php
/* @var $this OrderController */
/* @var $orderId */
/* @var $selectedOrders array() */
 ?>
	<div class="row form-group">
	<div class="col-sm-9 col-xs-10 col-xs-offset-1 col-sm-offset-0">
		<br>
		<br>
		<label class="required">Order Number: </label>
			<i style="color: rgba( 0,0,0, 0.5);"><?php echo $orderId;?></i><br><br>
		<label class="required">Payment Mode: </label>
			<i style="color: rgba( 0,0,0, 0.5);"><?php echo $selectedOrders[0]->payment_mode;?></i><br><br>
		<label class="required">Wallet Amount Used: </label>
			<i style="color: rgba( 0,0,0, 0.5);"><?php echo '<b><i class="fa fa-inr"></i> '.' '.$selectedOrders[0]->wallet_amount_used.' </b>';?></i><br><br>
		<label class="required">Customer's Phone: </label>
			<i style="color: rgba( 0,0,0, 0.5);"><?php echo $selectedOrders[0]->destination_phone;?></i><br><br>
		<label class="required">Customer's Address: </label>
			<i style="color: rgba( 0,0,0, 0.5);"><?php echo $selectedOrders[0]->destination_address;?></i><br><br>
		<label class="required">Customer's Locality: </label>
			<i style="color: rgba( 0,0,0, 0.5);"><?php echo $selectedOrders[0]->destination_locality;?></i>
		<br>
		<br>
		<br>
		<label class="required">List of purchase:</label>

	<table class="table table-condensed" id="delivrytimeselecttable" style="table-layout: fixed;">
	<tbody>
		<tr>
			<th class="wordwrap" style="width: 40%;">Item</th>
			<th class="wordwrap" style="width: 10%;">Qty</th>
			<th class="wordwrap" style="width: 35%;">Delivery Time</th>
			<th class="wordwrap" style="width: 15%;">Subtotal</th>
		</tr>
	
	<?php
	$orderValue = 0;
	/* @var $row TiffinPriceTimeSelectionForm */
	foreach ( $selectedOrders as $key => $row) 
	{
		$tiffinObj = $row->order2tiffin0;
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
		echo $row->num_of_units;
		echo '</td>';
		
		echo '<td>';
		echo AppCommon::getDetailedDateString( $row->order_delivery_time );
		echo '</td>';
		
		echo '<td>';
		echo '<b><i class="fa fa-inr"></i> '.' '.$row->total_price.' </b>';
		echo '</td>';
		
		echo '</tr>';
		$orderValue = $orderValue + $row->total_price;
	}
		?>
	
	</tbody>
	</table>
		<br>
		<br>
		<label class="required">Total Cost of Order: </label>
			<i style="color: rgba( 0,0,0, 0.5);"><?php echo '<b><i class="fa fa-inr"></i> '.' '.$orderValue.' </b>';?></i><br><br>
	</div>
	</div>