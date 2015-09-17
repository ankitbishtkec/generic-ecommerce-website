<?php
/* draw single result here */
?>
<?php if( isset( $data->aPriceTimes[0] ) ): ?>
<div class="col-sm-6 col-md-4">
    <div class="thumbnail">
      <a  target="_blank" href="<?php echo CHtml::normalizeUrl( array('tiffin/view', 'id'=>$data->name
      ."-".$data->id)); ?>">
      <img src="<?php echo $imagePath;?>" alt="Loading..."  style="width: 100%; height: 255px;">
		</a>
        <div style='overflow:auto;height:120px;' class='wordwrap'>
        <b style="font-size: 140%;"><?php echo CHtml::encode($data->name); ?></b><br>
        <i style="color: red;"> created by <?php echo CHtml::link(CHtml::encode($data->tiffin2userDetails->unique_name), 
        	array('userdetails/view', 'id'=>$data->tiffin2userDetails->unique_name.'-'.
        	$data->tiffin2userDetails->first_name.'-'.
        	$data->tiffin2userDetails->last_name.'-'.
			$data->tiffin2userDetails->id),
			array( 'target' => '_blank',)); ?>
        </i>
        <p style="margin-bottom: 0px;">
        	<?php
        	$i=0;
			$j=0;
        	for(; $j < ( (int)(($data->rating_of_tiffin)/2) ); )
        	{
        		echo '<i class="fa fa-star" style="color: #FCE712;"></i>';
				$i++;
				$j++;
        		
			}
			
			if( (($data->rating_of_tiffin) % 2) > 0 )
			{
				echo '<i class="fa fa-star-half-full" style="color: #FCE712;"></i>';
				$i++;
			}
        	for(; $i < 5; $i++)
        	{
				echo '<i class="fa fa-star" style="color: #EAEAE4;"></i>';
        	}
			echo ' ('.($data->num_of_reviews).' reviews)';
			?>
		</p>
        <p><?php echo CHtml::encode($data->contents); ?></p>
        </div>
        <div class="well wordwrap" style="padding: 5px; overflow:auto; height: 52px; margin-top: 5px; margin-bottom: 0px;
        border-bottom-right-radius: 0px; border-bottom-left-radius: 0px;">
        	

        	<!--b>Order slot - </b><?php
        		echo AppCommon::getDetailedDateString( $data->aPriceTimes[0]->order_end_time );
        	 ?>
        	<br>
        	<b>Delivery around - </b><?php
        		echo AppCommon::getDetailedDateString( $data->aPriceTimes[0]->order_delivery_time );
        	 ?>
        	<br-->
        	<i class="fa fa-inr"></i><?php echo CHtml::encode("  ".$data->aPriceTimes[0]->price_after_discount).' /-'; ?>
        	<?php echo '<span class="label label-danger" style="margin-right: 2px;display: inline-block;">'.CHtml::encode( " - ".$data->aPriceTimes[0]->discount."% applied" ).'</span>';?>

		<br>
		<i class="fa fa-tags"></i>
        <?php
			foreach($data->aFoodTagsAll as $tag )
			{
				echo '<span class="label label-success" style="margin-right: 2px;display: inline-block;">'.CHtml::encode( $tag->tag_name ).'</span>'; 	
			}
		?>
        </div>
        <?php if( ( $data->aPriceTimes[0]->quantity_currently_available ) > 0 ): ?>
        <button id="add_cart" 
        data-tiffinid="<?php echo CHtml::encode($data->id); ?>" 
        type="button" class="btn btn-warning btn-lg btn-block"
        style="border-top-right-radius: 0px; border-top-left-radius: 0px;">
        <!--ADD TO CART/ -->BUY @ <i class="fa fa-inr"></i><?php echo CHtml::encode("  ".$data->aPriceTimes[0]->price_after_discount).' /-'; ?>
        </button>
        <?php else: ?>
        <button  
        type="button" class="btn btn-danger btn-lg btn-block"
        style="border-top-right-radius: 0px; border-top-left-radius: 0px;" disabled>
        SOLD OUT
        </button>
        <?php endif; ?>
    </div>
  </div>
<?php endif; ?>