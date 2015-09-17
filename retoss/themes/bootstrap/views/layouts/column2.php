<?php /* @var $this Controller */ ?>
<?php $this->beginContent('//layouts/main'); ?>

<div style="z-index:950;position:fixed; left: 0%;top: 15%;">
	<div style="height: 100%; width: 300px; display: none; float: left;">

	</div>
	<div id="floatingCartButton" class="btn btn-info text-center wordwrap" style="width:40px; padding:3px;
	border-top-left-radius: 0px; border-bottom-left-radius: 0px; float: left; margin-top: 0px;">
		<i class="fa fa-shopping-cart" style="color: #ffffff;font-size: 150%;">
		</i><br>
    	C<br>A<br>R<br>T<br>
    	<span id="floatingCartButtonValue" class="badge">
    	<?php echo( AppCommon::cartItemCount( ) ); ?>
    	</span>
	</div>
</div>

<div class="row">
    <div class="span9">
        <div id="content">
            <?php echo $content; ?>
        </div><!-- content -->
    </div>
    <!--div class="span3">
        <div id="sidebar">
        <?php
            $this->beginWidget('zii.widgets.CPortlet', array(
                'title'=>'Operations',
            ));
            $this->widget('bootstrap.widgets.TbMenu', array(
                'items'=>$this->menu,
                'htmlOptions'=>array('class'=>'operations'),
            ));
            $this->endWidget();
        ?>
        </div>
    </div-->
</div>
<?php $this->endContent(); ?>