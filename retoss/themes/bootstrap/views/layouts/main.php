<?php /* @var $this Controller */ ?>
<!DOCTYPE html>
<!--Author: Ankit Bisht
Author email: ankit.bisht.kec@gmail.com, ankit.bisht.com@gmail.com
Author LinkedIn profile: https://in.linkedin.com/pub/ankit-bisht/16/a6/167
License: Apache License 2.0
License URL: http://www.apache.org/licenses/LICENSE-2.0.html
-->
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="language" content="en" />
	<link rel="shortcut icon" href="<?php echo AppCommon::getAppFolderUrl(); ?>/favicon.ico" type="image/icon"> 
	<link rel="icon" href="<?php echo AppCommon::getAppFolderUrl(); ?>/favicon.ico" type="image/icon">

    <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->theme->baseUrl; ?>/css/styles.css" />

	<title><?php echo CHtml::encode($this->pageTitle); ?></title>

	<?php Yii::app()->bootstrap->register(); ?>
</head>

<body>

<?php 
$pathMain = Yii::app()->getBasePath().'/jsFiles/';
Yii::app()->assetManager->publish($pathMain, true, -1, false);
$pathMain1 =  Yii::app()->assetManager->getPublishedUrl(  $pathMain );
Yii::app()->getClientScript()->registerScriptFile( $pathMain1.'/layoutPageScript.js');
Yii::app()->getClientScript()->registerScriptFile( $pathMain1.'/cart.js');//added to provide cart facility in every screen


$pathMain2 = Yii::app()->getBasePath().'/cssFiles/';
Yii::app()->getClientScript()->registerCssFile( Yii::app()->assetManager->publish($pathMain2, true, -1, false).'/layoutPageStyle.css');

Yii::app()->getClientScript()->registerScript(__CLASS__.'#'."main1", 
"var globalUrl = '" .AppCommon::getSiteBaseUrl()."';".
"\nvar globalAppFolderUrl = '".AppCommon::getAppFolderUrl()."';".
"\nvar cartErrorMsgTiffinNotExist = '".AppCommon::$cartErrorMsgTiffinNotExist."';".
"\nvar cartErrorMsgTiffinNotAvailable = '".AppCommon::$cartErrorMsgTiffinNotAvailable."';".
"\nvar cartErrorMsgTiffinQuanCappedToLimits = '".AppCommon::$cartErrorMsgTiffinQuanCappedToLimits."';".
"\nvar cartErrorMsgTiffinNotAvailableInCurrLocality = '".AppCommon::$cartErrorMsgTiffinNotAvailableInCurrLocality."';".
"\nvar csrfTokenKey = '".Yii::app()->request->csrfTokenName."';".
"\nvar csrfTokenValue = '".Yii::app()->request->getCsrfToken()."';",
CClientScript::POS_END);
Yii::app()->getClientScript()->registerScript(__CLASS__.'#'."main2", 
"initializeLayout();");
//analytics code
Yii::app()->getClientScript()->registerScript(__CLASS__.'#'."main3", 
"  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', '".Yii::app()->params['googleAnalyticsApiKey']."', 'auto');
  ga('require', 'linkid', 'linkid.js');
  ga('send', 'pageview');",
CClientScript::POS_END);//UA-60761488-1
Yii::app()->getClientScript()->registerScript(__CLASS__.'#'."main4", 
"addEventHandlersForFloatingCart( );");
?>

<nav class="navbar navbar-default navbar-fixed-top">
  <div class="container-fluid">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="<?php echo AppCommon::getSiteBaseUrl();?>">
	  <img src="<?php echo AppCommon::getAppFolderUrl();?>/images/logo_311x48.jpg" width="210" height="50" style="margin-top:-15px;" alt="tw.in"></a>
	  </a>
    </div>

    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      <ul class="nav navbar-nav">
        <li><a href="<?php echo AppCommon::getSiteBaseUrl().'/site/lovecooking'; ?>" style="display: none;">Love cooking? Join us</a></li>
        <li><a href="<?php echo AppCommon::getSiteBaseUrl().'/site/howitworks'; ?>" style="display: none;">How it works?</a></li>
        <li><a href="<?php echo AppCommon::getSiteBaseUrl().'/site/contact'; ?> ">Contact us</a></li>
      </ul>
      <ul class="nav navbar-nav navbar-right">
      	<?php if(Yii::app()->user->isGuest): ?>
        	<li><a href="<?php echo AppCommon::getSiteBaseUrl().'/user/registration'; ?>">Sign up!</a></li>
        	<li><a href="<?php echo AppCommon::getSiteBaseUrl().'/user/login'; ?>">Login</a></li>
		<?php else: ?>
        <li class="dropdown">
          <a href="" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
          	hi, <b><i><?php echo Yii::app()->user->name ?></i></b>
          	<span class="caret"></span>
          </a>
          <ul class="dropdown-menu" role="menu">
            <li  style="display: none;"><a href="<?php echo AppCommon::getSiteBaseUrl().'/site/lovecooking'; ?>">
            	Love cooking?
            	</a>
            </li>
            <li class="divider"  style="display: none;"></li>
            <li><a href="<?php echo AppCommon::getSiteBaseUrl().'/user/logout'; ?>">Logout</a></li>
          </ul>
        </li>
		<?php endif; ?>
      </ul>
    </div><!-- /.navbar-collapse -->

  </div><!-- /.container-fluid -->
</nav>

<div id="contactUsFull1" style="display:none;z-index:2902;position:fixed; left: 0px;top: 0px;
			background-color: #008168;filter: alpha(opacity=80); opacity: 0.80;width:100%;height:100%;">
				<div class="content" style="top: 20%;position: fixed;z-index:3002;width:100%;"> 		
					<div class="row">
  						<div class="col-xs-9 col-md-offset-3">
							<img src="<?php echo AppCommon::getAppFolderUrl();?>/images/ringing.gif" style="float: left;" alt="">
  							<p style="text-align: left;color:black;font-size:350%;
  							padding-top: 85px;filter: alpha(opacity=100); opacity: 1;">
  							Need Help?
  							<br>
  							+91-96 11 699669
  							</p>
  						</div>
					</div>
				</div>
</div>


<!-- addressAddModal start -->
<div class="modal fade" id="addressAddModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content" id="addressAddModalContent" >
    </div>
  </div>
</div>
<!-- addressAddModal stop -->


<!-- cartAddEditModal start -->
<div class="modal fade" id="cartAddEditModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content" id="cartAddEditModalContent" >
    </div>
  </div>
</div>
<!-- cartAddEditModal stop -->

<!-- floatingCart start -->
<!-- here bootstrap is used to show the floated cart only z-index has been changed
	to make sure that cartAddEditModal, having default z-index = 1040( this default value 
	is based on the variables in .less files, represented in .map files 
	 http://stackoverflow.com/questions/21504611/what-are-the-map-files-used-for-in-bootstrap-3-1, 
	 which generated bootstrap.css file), pops up above it  -->
<div class="modal fade" id="floatingCartModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" 
	style="z-index:1030;" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content" id="floatingCartModalContent" >
    </div>
  </div>
</div>
<!-- floatingCart stop -->
<div class="container" id="page" style="min-height:	 850px;
/*added just to make footer look good in pages that are smaller than the height
 of screen/ monitor*/">

<!--div class="alert alert-warning alert-dismissible" role="alert">
  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
  <strong>Good news!</strong> We are now accepting SODEXO COUPONS on delivery.
</div-->
<div class="row">
<div class="col-sm-1 hidden-xs">
		<!--  This div is used as the left side margin. Please do not mess with this ...-->
</div>
<div class="col-sm-10 col-xs-12">
	<?php
	 //breadcrumbs code was here
	?>
<!--div class="alert alert-danger text-center" role="alert"><b>Currently we are not accepting any orders. However, we will start accepting orders very soon.</b></div-->
	<?php echo $content; ?>

</div>
<div class="col-sm-1 hidden-xs">
	<!--  This div is used as the right side margin. Please do not mess with this ...-->
</div>
</div>
</div><!-- page -->
<br>
<!--div class="  text-center" style="filter: alpha(opacity=90); opacity: 0.90;background-color: #000000;">
    <div class="row">
		<div>
            <h2 style="color:#fff">CONTACT US</h2>
            <h3>
            <a href="tel:+91-9999999999" style="font-weight:300;font-family:'Tahoma';color: #ffffff; text-decoration:none'"><i class="fa fa-phone-square"></i> +91-9999999999</a>
            </h3>
            <h3>
            <a href="mailto:contactus@tw.in" style="font-weight:300;font-family:'Tahoma';color: #ffffff; text-decoration:none'"><i class="fa fa-envelope"></i> contactus@tw.in</a>
            </h3>
            <h3 class="fa-hover">
            <a target="_blank" href="https://www.facebook.com/tw.in" style="margin-right: 30px;font-weight:300;font-family:'Tahoma';color: #ffffff; text-decoration:none'"><i class="fa fa-facebook-official"></i> Like us       </a>
            <a target="_blank" href="https://www.twitter.com/tw" style="font-weight:300;font-family:'Tahoma';color: #ffffff; text-decoration:none'"><i class="fa fa-twitter"></i> Follow us</a>
            </h3>
        </div>
    </div>
</div>
      <div class="container-fluid" style="filter: alpha(opacity=90); opacity: 0.90;background-color: #DCFDFD;
      font-family:'Tahoma';color: #000000;">
        <div class="row">
          <div class="col-sm-8">
              <p id="copyright-section"> 
              	<a target="_blank" href="<?php echo AppCommon::getSiteBaseUrl().'/site/page/view/about'; ?>">About</a> | 
              	<a target="_blank" href="#">Team</a> | 
              	<a target="_blank" href="#">Blog</a> | 
              	<a target="_blank" href="#">Terms of Service</a> | 
              	<a target="_blank" href="#">Privacy Policy</a> | 
              	<a target="_blank" href="#">FAQ</a> | 
              	<a target="_blank" href="#">Attributions</a></p>
          </div>
          <div class="col-sm-4">
            <p id="copyright-section">
              Copyright &copy; <?php echo date('Y'); ?> by Put Your Enterprise Name pvt. ltd.<br/>
			  All Rights Reserved.
            </p>
          </div>
        </div>
      </div-->

</body>
</html>
