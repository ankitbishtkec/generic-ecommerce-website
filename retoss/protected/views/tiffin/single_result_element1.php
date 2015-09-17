<?php
/* draw single result here */
?>
<?php if( isset( $data->aPriceTimes[0] ) ): ?>
<div class="col-sm-6 col-xs-12 zero_margin_padding_me_and_descendants" >
    <div class="thumbnail" style="border:none; box-shadow:none;padding: 0;">
      <a  target="_blank" href="<?php echo CHtml::normalizeUrl( array('tiffin/view', 'id'=>$data->name
      ."-".$data->id)); ?>">
      <img src="<?php echo $imagePath;?>" alt="Loading..."  style="width: 100%; height: 375px;">
		</a>
        <div style='overflow:auto;height:125px; padding: 0 5px;' class='wordwrap row'>
        <div class="col-xs-6"  style="font-size: 20px; text-transform: uppercase; color:rgba( 0 , 0, 0, 0.75);)">
        	<?php echo CHtml::encode($data->name); ?>
        </div>
        <div class="col-xs-6" style="text-align: right;">
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
			echo '<i  style="color:rgba( 0 , 0, 0, 0.5);">  ('.($data->num_of_reviews).' reviews )</i> ';
			?>
        </div>
        <!--i style=";"> created by <?php echo CHtml::link(CHtml::encode($data->tiffin2userDetails->unique_name), 
        	array('userdetails/view', 'id'=>$data->tiffin2userDetails->unique_name.'-'.
        	$data->tiffin2userDetails->first_name.'-'.
        	$data->tiffin2userDetails->last_name.'-'.
			$data->tiffin2userDetails->id),
			array( 'target' => '_blank',)); ?>
        </i-->
        <div class="col-xs-12" style="text-align: left; font-size: 14px; color:rgba( 0 , 0, 0, 0.5);">
        	<div class='wordwrap row'>
        		<div class="col-xs-8" style="text-align: left; font-size: 14px; color:rgba( 0 , 0, 0, 0.5);">
        			<div class='wordwrap row'>
        				<div class="col-xs-12" style="text-align: left; font-size: 14px; color:rgba( 0 , 0, 0, 0.6);">
        					<?php echo CHtml::encode($data->contents); ?>
        				</div>
        				<div class="col-xs-12"  style="font-size: 18px; text-transform: uppercase; color:rgba( 0 , 0, 0, 0.5);)">
        					<i class="fa fa-inr"></i><?php echo CHtml::encode("  ".$data->aPriceTimes[0]->price_after_discount).' /-'; ?>
        				</div>
        			</div>
        		</div>
        		<div class="col-xs-4" style="text-align: right; font-size: 14px; color:rgba( 0 , 0, 0, 0.5);">				
			        <?php if( ( $data->aPriceTimes[0]->quantity_currently_available ) > 0 ): ?>
			        <button id="add_cart" 
			        data-tiffinid="<?php echo CHtml::encode($data->id); ?>" 
			        type="button" class="btn btn-default btn-xs"
			        style="border-top-right-radius: 0px; border-top-left-radius: 0px;">
			        add
			        </button>
			        <?php else: ?>
			        <button  
			        type="button" class="btn btn-default btn-xs"
			        style=";" disabled>
			        sold out
			        </button>
			        <?php endif; ?>
        		</div>
        	</div>
        </div>
        
        </div>
    </div>
  </div>
<?php endif; ?>