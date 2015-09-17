<?php

class CartController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	//public $layout='//layouts/column2';
	public $layout='//layouts/column2_withoutcart';//this layout view do not have side cart button

	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
			'postOnly + delete', // we only allow deletion via POST request
		);
	}

	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
	public function accessRules()
	{
		return array(
			array('allow',
				'actions'=>array('GetQuantity', 'AddToCart', 'DeleteFromCart', 'ClearCart', 'GetCart',),
				'users'=>array('*'),
			),
			array('allow',
				'actions'=>array('buy', 'Checkout',),
				'users'=>array('@'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}	
	
	/**
	 * cart cookie data structure
	 * array(
	 * "tiffin_id_1"=>array( quantity, added date),
	 * "tiffin_id_2"=>array( quantity, added date),
	 * 		)
	 * 
	 * 
	 * input argument is tiffin id
	 * return the number of quantity already present in cart return zero is tiffin does not exists or tiffin is not
	 * in cart
	 */
	public function getAlreadyPresentTiffinQuantityInCart( $tiffinId )
	{
		$response = 0;
		if( Yii::app()->user->isGuest )//saved in cookie
		{
			$allCookies = Yii::app()->request->getCookies();
			$cartCookiesArr = array();
			if( isset( $allCookies[ Yii::app()->params['cartCookieName'] ] ) )
				$cartCookiesArr = CJSON::decode( $allCookies[ Yii::app()->params['cartCookieName'] ]->value, true );
			if( isset( $cartCookiesArr ) )//if cookie exists
			{
				if( isset( $cartCookiesArr[ $tiffinId ] ) )// record for tiffinid exists
					$response = $cartCookiesArr[ $tiffinId ][ 0 ];
			}
		}
		else //saved in db
		{	
			$alreadyPresentRecord = ACart::model()->findAll( array(
        		'condition'=>'is_deleted = "no" AND cart2user = '.AppCommon::getUserDetailsId().' AND cart2tiffin = '
        		.$tiffinId,
    			) 
			);
			if( isset( $alreadyPresentRecord ) and isset( $alreadyPresentRecord[0] ) )//if record exists
			{
					$response = $alreadyPresentRecord[0]->quantity;
			}
		}
		
		return $response;
	}
	
	/**
	 * gets cart values
	 * $location to select tiffins at a particular location
	 * $doeditcart edit cart if needed.
	 * return
	 */
	public function actionGetCart( $doecho = 1, $location = null, $doeditcart = 1 )
	{
		/*Yii::ankFileSave( var_export( AppCommon::modifyInputTiffinsQuantity( 
		array(
		1=>2,
		9=>1,
		10=>20,
		11=>0,
		16=>1,
		)
		, "Embassy Tech Village" ) ,true));
		echo "wahh wahh";
		return;*/
		$cartData = null;
		if( Yii::app()->getRequest()->getIsAjaxRequest() and $_GET['ajax'] == 1 )
			$cartData = ACart::getCart( $location, $doeditcart );
		
		if( $doecho == 1  )
		{
			echo CJSON::encode( $cartData );
			return;
		}
		else 
		{
			return CJSON::encode( $cartData );	
		}
	}
	
	/**
	 * clear user's cart unapologetically
	 * return ok and not ok for success and failure respectively
	 */
	public function actionClearCart( $doecho = 1 )
	{
		$response = array();
		$response["message"] = "not ok";
		if( Yii::app()->getRequest()->getIsAjaxRequest() and $_GET['ajax'] == 1 )
		{
			if( Yii::app()->user->isGuest )//saved in cookie
			{				
				$response["message"] = "ok";
				$allCookies = Yii::app()->request->getCookies();
				$cartCookiesArr = array();//empty cart array
				
				//update the cookie
				$allCookies[ Yii::app()->params['cartCookieName'] ] = 
				new CHttpCookie( Yii::app()->params['cartCookieName'], CJSON::encode( $cartCookiesArr ), 
				array(
					'expire'=> time()+60*60*24*100,//in seconds 100 days
					'httpOnly'=>true,
				));
			}
			else //saved in db
			{				
				$response["message"] = "ok";	
				$alreadyPresentRecord = ACart::model()->findAll( array(
        			'condition'=>'is_deleted = "no" AND cart2user = '.AppCommon::getUserDetailsId(),
    				) 
				);
				foreach( $alreadyPresentRecord as $rec)
				{
					$rec->is_deleted = AppCommon::getUserDetailsId();
					$rec->save();
				}	
			}	
		}
		$response["total_items"] = AppCommon::cartItemCount( );
		if( $doecho == 1  )
		{
			echo CJSON::encode( $response );
			return;
		}
		else 
		{
			return CJSON::encode( $response );	
		}
	}
	
	
	/**
	 * deletes tiffin from user's cart unapologetically
	 * return number of items to increased or decreased in cart and success or failure
	 */
	public function actionDeleteFromCart($id, $doecho = 1)
	{
		$response = array();
		$response["message"] = "not ok";
		$response["change"] = 0;		
		if( Yii::app()->getRequest()->getIsAjaxRequest() and $_GET['ajax'] == 1 )
		{
			if( Yii::app()->user->isGuest )//saved in cookie
			{				
				$response["message"] = "ok";
				$allCookies = Yii::app()->request->getCookies();
				$cartCookiesArr = array();
				if( isset( $allCookies[ Yii::app()->params['cartCookieName'] ] ) )
				{
					$cartCookiesArr = CJSON::decode( $allCookies[ Yii::app()->params['cartCookieName'] ]->value
					, true );
				}
				//check if tiffin with id exists
				if( isset( $cartCookiesArr[ $id ] ) )
				{
					$response["change"] = -1 * $cartCookiesArr[ $id ][ 0 ] ;
					unset( $cartCookiesArr[ $id ] );
				}
				
				//update the cookie
				$allCookies[ Yii::app()->params['cartCookieName'] ] = 
				new CHttpCookie( Yii::app()->params['cartCookieName'], CJSON::encode( $cartCookiesArr ), 
				array(
					'expire'=> time()+60*60*24*100,//in seconds 100 days
					'httpOnly'=>true,
				));
			}
			else //saved in db
			{				
				$response["message"] = "ok";	
				$alreadyPresentRecord = ACart::model()->findAll( array(
        			'condition'=>'is_deleted = "no" AND cart2tiffin = '.$id.
        			' AND cart2user = '.AppCommon::getUserDetailsId(),
    				) 
				);
				if( isset( $alreadyPresentRecord[ 0 ] ) )
				{
					$response["change"] = -1 * $alreadyPresentRecord[ 0 ]->quantity ;
					$alreadyPresentRecord[ 0 ]->is_deleted = AppCommon::getUserDetailsId();
					$alreadyPresentRecord[ 0 ]->save();
				}	
			}	
		}
		$response["total_items"] = AppCommon::cartItemCount( );
		if( $doecho == 1  )
		{
			echo CJSON::encode( $response );
			return;
		}
		else 
		{
			return CJSON::encode( $response );	
		}
	}
	
	/**
	 * it does not adds to cart rather it sets the value in cart after making quantity value zero. 
	 * 
	 * returns number of items to increased or decreased in cart and success or failure
	 * cart cookie data structure
	 * array(
	 * "tiffin_id_1"=>array( quantity, added date),
	 * "tiffin_id_2"=>array( quantity, added date),
	 * 		)
	 */
	public function actionAddToCart($id, $quantity, $doecho = 1)
	{
		$response = array();
		$response["message"] = "not ok";
		$response["change"] = 0;		
		if( ( ( Yii::app()->getRequest()->getIsAjaxRequest() and $_GET['ajax'] == 1 ) || $doecho == 0 )
		 and ( $quantity > 0 ) )
		{
			$currDateTime = new DateTime();
			$currDateTime = $currDateTime->format('Y-m-d H:i:s');
			if( Yii::app()->user->isGuest )//saved in cookie
			{				
				$response["message"] = "ok";
				$allCookies = Yii::app()->request->getCookies();
				$cartCookiesArr = array();
				if( isset( $allCookies[ Yii::app()->params['cartCookieName'] ] ) )
				{
					$cartCookiesArr = CJSON::decode( $allCookies[ Yii::app()->params['cartCookieName'] ]->value
					, true );
				}
				//check if tiffin with id exists
				if( isset( $cartCookiesArr[ $id ] ) )
				{
					$response["change"] = $quantity - $cartCookiesArr[ $id ][ 0 ];
					$cartCookiesArr[ $id ][ 0 ] = $quantity;
				}
				else //if not create new
				{
					$cartCookiesArr[ $id ][ ] = $quantity;
					$cartCookiesArr[ $id ][ ] = $currDateTime;	
					$response["change"] = $quantity;
				}
				//update the cookie
				$allCookies[ Yii::app()->params['cartCookieName'] ] = 
				new CHttpCookie( Yii::app()->params['cartCookieName'], CJSON::encode( $cartCookiesArr ), 
				array(
					'expire'=> time()+60*60*24*100,//in seconds 100 days
					'httpOnly'=>true,
				));
			}
			else //saved in db
			{				
				$response["message"] = "ok";	
				$alreadyPresentRecord = ACart::model()->findAll( array(
        			'condition'=>'is_deleted = "no" AND cart2tiffin = '.$id.
        			' AND cart2user = '.AppCommon::getUserDetailsId(),
    				) 
				);
				if( isset( $alreadyPresentRecord[ 0 ] ) )
				{
					$response["change"] = $quantity - $alreadyPresentRecord[ 0 ]->quantity;
					$alreadyPresentRecord[ 0 ]->quantity = $quantity;
					$alreadyPresentRecord[ 0 ]->added_time = $currDateTime;
					$alreadyPresentRecord[ 0 ]->save();
				}
				else 
				{
					try//added as cart2tiffin is foriegn key and $id can be any garbage value so it can error out
					{
						$model=new ACart;
						$model->cart2tiffin = $id;
						$model->cart2user = AppCommon::getUserDetailsId();
						$model->quantity = $quantity;
						$model->added_time = $currDateTime;
						$model->save();	
						$response["change"] = $quantity;
					}
					catch( Exception $e )
					{
						$ignored = true;//added to ignore exception
						$response["message"] = "not ok";
						$response["change"] = 0;
					}
				}	
			}	
		}
		$response["total_items"] = AppCommon::cartItemCount( );
		if( $doecho == 1  )
		{
			echo CJSON::encode( $response );
			return;
		}
		else 
		{
			return CJSON::encode( $response );	
		}
	}
	
	/**
	 * write documentation
	 * 
	 * 
	 */
	public function actionGetQuantity($id, $doecho = 1)
	{
		if( Yii::app()->getRequest()->getIsAjaxRequest() and $_GET['ajax'] == 1)
		{
			$currDateTime = new DateTime();
			$currDateTime = $currDateTime->format('Y-m-d H:i:s');
			$selectedTiffin = ATiffin::model()->findAll( array(
    				'select'=>'t.id, t.name, t.contents',
        			'condition'=>'t.verified_by != "not verified" AND t.is_deleted = "no" AND t.id = '.$id,
        			'order'=> 't.id, aPriceTimes.order_delivery_time ASC' ,//added to keep fastest delivery row on top at index 0
	        		'with'=>
    	    		array(
	    			'aPriceTimes'=>
    	    			array(
    	    			'select'=>'aPriceTimes.price_after_discount, aPriceTimes.order_end_time, 
    	    					aPriceTimes.order_delivery_time, aPriceTimes.quantity_currently_available, 
    	    					aPriceTimes.orderType, aPriceTimes.discount',
						'on'=>'aPriceTimes.order_start_time <= '.'"'.$currDateTime.'"'.
						' AND aPriceTimes.quantity_currently_available > 0 '.
						' AND aPriceTimes.order_end_time >= '.'"'.$currDateTime.'"',
        				'condition'=>'aPriceTimes.verified_by != "not verified" AND aPriceTimes.is_deleted = "no"',	
							),
						),
    				) );
			$response = array();
			if( isset( $selectedTiffin[0] ) and isset( $selectedTiffin[0]->aPriceTimes[0] ) )
			{
				$response[ "id" ] = $selectedTiffin[0]->id;
				$response[ "name" ] = $selectedTiffin[0]->name;
				$response[ "contents" ] = $selectedTiffin[0]->contents;
				$response[ "discounted_price" ] = $selectedTiffin[0]->aPriceTimes[0]->price_after_discount;
				$response[ "discount" ] = $selectedTiffin[0]->aPriceTimes[0]->discount;
				$response[ "order_delivery_time" ] = $selectedTiffin[0]->aPriceTimes[0]->order_delivery_time;
				$response[ "quantity" ] = $selectedTiffin[0]->aPriceTimes[0]->quantity_currently_available;
				$response[ "selected_value" ] = $this->getAlreadyPresentTiffinQuantityInCart( $id ); 
				$response[ "message" ] = "ok";
			}
			else 
			{
				$response[ "message" ] = "not ok";	
			}
			$response["total_items"] = AppCommon::cartItemCount( );
			if( $doecho == 1  )
			{
				echo CJSON::encode( $response );
				return;
			}
			else 
			{
				return CJSON::encode( $response );	
			}
		}
	}
	
	/**
	 * $id is order unique id
	 *
	 * TODO::add comments
	 */
	public function actionCheckout( $id = null )
	{
		$sm=Yii::app()->getSecurityManager();
		$orderId = $id;
		$selectedOrders = null;
		
		if( isset( $orderId ) )
		{
			if( ($orderId=$sm->validateData($orderId)) == false )//valdate if orderId is not forged
			{
				$this->render('cart_error',array('errorMessage'=>"Either this page does not exists or has expired.", 
					'link'=>CHtml::normalizeUrl( array('site/index') ) ) );
				Yii::app()->end();
			}
			//if order id exists and belongs to current user and is in 'order_start' status
			//(other status mean order has already crossed the checkout process once)
			//as order id's input has been added to checkout action to facilitate the 
			//order resumption. Note: As order is being modified or created in this function
			//do check before any POST or GET if order can be modified. Order can be modified
			//only and only if it is in 'order-start' status.
			$selectedOrders = AOrder::model()->findAll( array(
        			'condition'=>'is_deleted = "no" AND ordered_by2user_details = '.AppCommon::getUserDetailsId().
        			' AND  order_unique_id = "'.$orderId.'" '.
        			' AND  status = "order_start" ',//'order_start' status
    				) 
				);
			if( !( isset( $selectedOrders ) ) || count( $selectedOrders ) < 1 )//no orders selected
			{
				$this->render('cart_error',array('errorMessage'=>"Either this page does not exists or has expired or you are not allowed to view this page.", 
					'link'=>CHtml::normalizeUrl( array('cart/checkout') ) ) );
				Yii::app()->end();
			}
		}
			
		$model = new CheckoutFirstStageForm();
		if( Yii::app()->getRequest()->getRequestType() == 'GET' || 
			 isset( $_POST[ 'CheckoutFirstStageForm' ] ) )//CHtml::modelName($model)
		// if GET request or POST request with 'CheckoutFirstStageForm' array set
		{
			if( isset( $orderId ) && Yii::app()->getRequest()->getRequestType() == 'GET' )
			//if orderId exists, add the items retreived from $orderId to cart
			{
				//first add the items retreived from $orderId to cart
				if( isset( $selectedOrders ) )
				foreach( $selectedOrders as $row)
				{
					$this->actionAddToCart( $row->order2tiffin , $row->num_of_units, 0);
					$model->address = $row->order2address;
					$model->phone = $row->destination_phone;
					$model->customerLocality = $row->destination_locality;
				}
			}
			
			if( AppCommon::cartItemCount() < 1  ) //if no items in cart
			{
				$this->render('cart_error',array('errorMessage'=>"Cart is empty.", 
				'link'=>CHtml::normalizeUrl( array('site/index') ) ) );
				Yii::app()->end();
			}
			
			//handling POST method here
			if(isset($_POST['CheckoutFirstStageForm'])) 
			{
				$model->attributes=$_POST['CheckoutFirstStageForm'];
				if( $model->validate() )
				{
					//get a order id if not there create new 
					//after this if we will have a order id for sure :)
					if( !isset( $orderId ) &&
					( $orderId = AppCommon::getUniqueOrderNumForUser( AppCommon::getUserDetailsId() ) ) == false )
					{
						$this->render('cart_error',array('errorMessage'=>"Order number could not be created.", 
						'link'=>CHtml::normalizeUrl( array('site/index') ) ) );
						Yii::app()->end();
					}
					
					//Yii::ankFileSave( $orderId );
					//create order rows in table
					$transaction=Yii::app()->db->beginTransaction();
					try
					{
						//remove all old records if any with supplied orderId
						if( isset( $selectedOrders ) && count( $selectedOrders ) > 0 )
						foreach( $selectedOrders as $row)
						{
							$row->is_deleted = AppCommon::getUserDetailsId();
							$row->save();
						}
						
						$currDateTime = new DateTime();
						$currDateTime = $currDateTime->format('Y-m-d H:i:s');
						//Yii::ankFileSave( var_export( $model->getCartArray, true ) );
						//save orders rows for item in current locality
						foreach ( $model->getCartArray as $key => $value ) 
						{
							if( is_array( $value ) )//to filter only values having tiffin info
							{
								if( $value[ "is_available_at_current_locality" ] )
								{
									//saved order record
									$orderRecord = new AOrder();
									$orderRecord->order_unique_id = $orderId;
									$orderRecord->num_of_units = $value[ "quantity" ];
									$orderRecord->ordered_by2user_details = AppCommon::getUserDetailsId();
									$orderRecord->order2tiffin = $value[ "id" ];
									$orderRecord->order2address = $model->address;
									$orderRecord->status = 'order_start';
									$orderRecord->last_status_update = $currDateTime;
									$orderRecord->destination_phone = $model->phone;
									$orderRecord->destination_address = $model->getAddressData[ $model->address ][ 1 ];
									$orderRecord->destination_locality = $model->getAddressData[ $model->address ][ 0 ];
									if( ( $emailPhoneArr = AppCommon::getEmailAndBasePhoneNumForUser( $value[ "chef_id" ] ) ) )
									{
										if( isset( $emailPhoneArr[ 'phone' ] ) )
											$orderRecord->source_phone = $emailPhoneArr[ 'phone' ];
									}
									if( ( $AddressDataArrForChef = AppCommon::getBaseAddressDataForUser( $value[ "chef_id" ] ) ) )
									{
										foreach ($AddressDataArrForChef as $key1 => $value1) 
										{
											$orderRecord->source_address = $value1[ 1 ];
											$orderRecord->source_locality = $value1[ 0 ];	
										}
									}
									$orderRecord->save();
									
									//saved order history record
									AppCommon::createOrderHistoryRecord( $orderRecord->id, 'order_start',
										$currDateTime, $orderId);
									
									//TODO save phone number with user id in phone table if not exists already
								}
							} 
						}
						$transaction->commit();
					}
					catch(Exception $e)
					{
						//Yii::ankFileSave($e->getMessage());
						$transaction->rollback();
						$this->render('cart_error',array('errorMessage'=>"Order could not be created.", 
						'link'=>CHtml::normalizeUrl( array('site/index') ) ) );
						Yii::app()->end();
					}
						
					$secStage = new CheckoutSecondStageForm( $orderId, AppCommon::getUserDetailsId() );
					$secStage->validate();
					$secStage->clearErrors();//clear error as it the first time display of form
					//Yii::ankFileSave( var_export( $secStage, true ) );
					$this->render('checkout_second_stage',array('model'=>$secStage, ) );
					Yii::app()->end();//stop here after displaying checkout second stage
				}
			}
			
			//datastructure format : array( addrId => array( locality, addrText ) )
			$addressArray = AAddress::getAllowedAddressForUser( AppCommon::getUserDetailsId() );
			$this->render('checkout_first_stage',array('model'=>$model, 
				'addressArray'=>$addressArray, ) );
		}
		else if( isset($_POST['CheckoutSecondStageForm']) && isset( $orderId ) && isset( $orderId ) && 
			isset( $selectedOrders ) && count( $selectedOrders ) > 0 )
		{
			$secStage1 = new CheckoutSecondStageForm( $orderId, AppCommon::getUserDetailsId() );
			$secStage1->attributes=$_POST['CheckoutSecondStageForm'];
			foreach( $secStage1->tiffinPriceTimeSelectionArr as $key1=>$value1 )
			{
				if( isset( $_POST['TiffinPriceTimeSelectionForm'][ $key1 ] ) )
				{
					$value1->attributes = $_POST['TiffinPriceTimeSelectionForm'][ $key1 ];
				}
			}
			//validation passed finishing orders
			if( $secStage1->validate() )
			{
				//TODO: javascript thing also
				//TODO: before displaying make sure pament method is set accoding to wallet money and total value
				//TODO: and discount and cash back value should be rest user should press verify to set them.
				//TODO: things to make order confirmed
				
				$transaction1 = Yii::app()->db->beginTransaction();
				try
				{		
					$currDateTime1 = new DateTime();
					$currDateTime1 = $currDateTime1->format('Y-m-d H:i:s');
					
					foreach ( $secStage1->tiffinPriceTimeSelectionArr as $key3 => $value3 ) 
					{
						/* @var $value3 TiffinPriceTimeSelectionForm */
						/* @var $aOrderObj $currOrder */
						$currOrder = $value3->aOrderObj;
						$currOrder->total_price = $value3->totalPrice;
						$currOrder->per_unit_price = $value3->perUnitPrice;
						$currOrder->order2price_time = $value3->selectedPriceTimeId;
						if( !AppCommon::isEmpty( $secStage1->couponCode ))//coupon saving
						{
							$currOrder->applied_offer_id = $secStage1->couponCode;
							if( $secStage1->billArray[ 1 ] != 0 )//instant discount
							{
								$currOrder->applied_order_amount = $secStage1->billArray[ 1 ];
							}
							else if( $secStage1->billArray[ 2 ] != 0 )//cashback
							{
								$currOrder->applied_order_amount = $secStage1->billArray[ 2 ];
							}
						}
						$currOrder->order_pickup_time = $value3->selectedAPriceTimeObj->order_pickup_time;
						$currOrder->order_delivery_time = $value3->selectedAPriceTimeObj->order_delivery_time;
						$currOrder->wallet_amount_used = $secStage1->amountUsedFromWallet;
						if( $secStage1->paymentMethod == 1 )//wallet
						{
							//order_start -> wallet -> order_confirmed
							$currOrder->payment_mode = 'wallet';
							AppCommon::createOrderHistoryRecord( $currOrder->id, 'wallet',
								$currDateTime1, $currOrder->order_unique_id);
							AppCommon::createOrderHistoryRecord( $currOrder->id, 'order_confirmed',
								$currDateTime1, $currOrder->order_unique_id);
							$currOrder->status = 'order_confirmed';
							$currOrder->last_status_update = $currDateTime1;
						}
						else if( $secStage1->paymentMethod == 2 )//online_payment
						{
							throw new Exception();
							//order_start -> online_payment -> awaiting_payment_confirmation -> payment_received -> order_confirmed/ order_failed
							$currOrder->payment_mode = 'online_payment';
							AppCommon::createOrderHistoryRecord( $currOrder->id, 'online_payment',
								$currDateTime1, $currOrder->order_unique_id);
							AppCommon::createOrderHistoryRecord( $currOrder->id, 'awaiting_payment_confirmation',
								$currDateTime1, $currOrder->order_unique_id);
						}
						else if( $secStage1->paymentMethod == 3 )//cod
						{
							//order_start -> cod -> awaiting_order_verification -> order_confirmed
							$currOrder->payment_mode = 'cod';
							AppCommon::createOrderHistoryRecord( $currOrder->id, 'cod',
								$currDateTime1, $currOrder->order_unique_id);
							AppCommon::createOrderHistoryRecord( $currOrder->id, 'awaiting_order_verification',
								$currDateTime1, $currOrder->order_unique_id);
							AppCommon::createOrderHistoryRecord( $currOrder->id, 'order_confirmed',
								$currDateTime1, $currOrder->order_unique_id);
							$currOrder->status = 'order_confirmed';
							$currOrder->last_status_update = $currDateTime1;
						}
						$currOrder->save();
					}
					
					if( $secStage1->paymentMethod == 1 )//wallet
					{
						//deduct money from wallet if wallet used
						AppCommonWallet::debitAmountFromWallet( $secStage1->amountUsedFromWallet, 'order_creation', 
							$currDateTime1, $secStage1->orderId, 'wallet', $secStage1->userId);
					}
					else if( $secStage1->paymentMethod == 3 )//cod
					{
						//deduct money from wallet if wallet used
						AppCommonWallet::debitAmountFromWallet( $secStage1->amountUsedFromWallet, 'order_creation', 
							$currDateTime1, $secStage1->orderId, 'wallet', $secStage1->userId);
					}
					$transaction1->commit();
				}
				catch(Exception $e)
				{
					Yii::ankFileSave($e->getMessage());
					$transaction1->rollback();
					$this->render( 'cart_error',array( 'errorMessage'=>"Order could not be created.", 
					'link'=>CHtml::normalizeUrl( array( 'cart/checkout', 'id'=>$secStage1->encryptedOrderId ) ) ) );
					Yii::app()->end();
				}
				$orderViewLink =  Yii::app()->getRequest()->getHostInfo().Yii::app()->getRequest()->getScriptUrl().
				'/order/view/id/'.$secStage1->encryptedOrderId ;
				Yii::ankFileSave( "order links" );
				Yii::ankFileSave( $orderViewLink );
					
				$subject_email = "tw.in Order Confirmation order no. ".$secStage1->orderId;
				$content_user = "Hi ".Yii::app()->user->name.",\n"."Your order no. ".$secStage1->orderId.
				" has been accepted. The url containing details of your order is \n\n\n".$orderViewLink./*CHtml::encode( $orderViewLink )*/
				"\n\n\n We will deliver the order by as per your selected time. We may call you for asking directions, if needed.".
				" Kindly receive the calls to make us deliver quickly. \nThanks and regards, \nTiffinwale.in team " ;
				//notify customer
				AppCommon::sendEmail( AppCommon::getEmail(), Yii::app()->user->name, $subject_email, 
				$content_user, array("order_notification_customer") );
										
				//notify tw team
				AppCommon::sendEmail( Yii::app()->params['adminEmail'], Yii::app()->user->name, $subject_email, 
				$content_user, array("order_notification_tiffinwale.in_team") );
					
				$content_sms = "Dear Customer, we have received your order no. ".$secStage1->orderId.
				". For more details click ".CHtml::encode( $orderViewLink )." or view email".
				" Thanks! tw.in";
				/*$content_sms = "Dear Customer, we have received your order from".
				" and it will be delivered between 12:30 PM to 2:00 PM. Thank You! tw.in";*/
				//sms customer
				AppCommon::sendSmsOnTime( $secStage1->tiffinPriceTimeSelectionArr[0]->aOrderObj->destination_phone, $content_sms, "null", true );
				AppCommon::sendSmsOnTime( '9999999999', $content_sms, "null", true );
				//redirect to view order details
				Yii::app()->getRequest()->redirect( $orderViewLink );
				//TODO: price time and cart value decrease
				Yii::app()->end();//stop here
			}
			$this->render('checkout_second_stage',array('model'=>$secStage1, ) );
		}
		else
		{
			$this->render('cart_error',array('errorMessage'=>"Few security issues has been detected with this request.", 
			'link'=>CHtml::normalizeUrl( array('site/index') ) ) );
			Yii::app()->end();
		}
	}
	
	
	/**
	 * aanan fanan me likha buy :P
	 */
	public function actionBuy($id)
	{
		return;
		$currDateTime = new DateTime();
		$currDateTime = $currDateTime->format('Y-m-d H:i:s');
		$selectedTiffin = ATiffin::model()->findAll( array(
    				'select'=>'t.id, t.name, t.contents',
        			'condition'=>'t.verified_by != "not verified" AND t.is_deleted = "no" AND t.id = '.$id,
        			'order'=> 't.id ASC, aPriceTimes.id ASC' ,
	        		'with'=>
    	    		array(
	    			'aPriceTimes'=>
    	    			array(
    	    			'select'=>'aPriceTimes.price_after_discount, aPriceTimes.order_end_time, aPriceTimes.discount, aPriceTimes.id, 
    	    					aPriceTimes.order_delivery_time, aPriceTimes.quantity_currently_available, 
    	    					aPriceTimes.orderType',
						'on'=>'aPriceTimes.order_start_time <= '.'"'.$currDateTime.'"'.
						' AND aPriceTimes.order_end_time >= '.'"'.$currDateTime.'"',
        				'condition'=>'aPriceTimes.verified_by != "not verified" AND aPriceTimes.is_deleted = "no"',	
							),
						),
    				) );
		if( isset( $selectedTiffin[0] ) and isset( $selectedTiffin[0]->aPriceTimes[0] ) )
		{		
			$model=new BuyForm;
			if(isset($_POST['BuyForm']))
			{
				$model->attributes=$_POST['BuyForm'];
				$model->name = Yii::app()->user->name;
				$model->email = AppCommon::getEmail( );
				if($model->validate())
				{
					$temp_date = DateTime::createFromFormat('Y-m-d H:i:s', $selectedTiffin[0]->aPriceTimes[0]->order_delivery_time);
					$temp_date_sms = $temp_date;
					if( $temp_date !=FALSE)
					{
						$temp_date_sms =  $temp_date->format('d M Y h:i a');//01 Apr 2015 01:22 am
						$temp_date = $temp_date->format('Y-M-d l, h:i:s a');
        			}
					Yii::ankFileSave("\n");
					Yii::ankFileSave("order-start");
					Yii::ankFileSave( $model->name );
					Yii::ankFileSave( $model->quantity );
					Yii::ankFileSave( $model->email );
					Yii::ankFileSave( $model->phone );
					Yii::ankFileSave( $model->quantity );
					Yii::ankFileSave( $model->techpark );
					Yii::ankFileSave( $model->address );
					Yii::ankFileSave( $model->paymentMode );
					Yii::ankFileSave( $selectedTiffin[0]->name );
					Yii::ankFileSave( $selectedTiffin[0]->id );
					Yii::ankFileSave( $selectedTiffin[0]->aPriceTimes[0]->id );
					Yii::ankFileSave( $temp_date );
					Yii::ankFileSave("order-stop");
					Yii::ankFileSave("\n");
					
					$subject_email = "Tiffin order confirmation ".$temp_date;
					$content_user = "Hi ".$model->name.",\n"."Your order comprising ".$model->quantity.
					" tiffin(s) of ".$selectedTiffin[0]->name." has been accepted.".
					" We will deliver the order by ".$temp_date." ( +/- 15 min. ) to ".$model->address.
					", ".$model->techpark.".\n The order is ".$model->paymentMode." and order's cost is ".
					$model->quantity." x ".$selectedTiffin[0]->aPriceTimes[0]->price_after_discount.
					" = Rs. ".( ($model->quantity) * ($selectedTiffin[0]->aPriceTimes[0]->price_after_discount)).
					". We may call on ".$model->phone." for asking directions, if needed.".
					" Kindly receive the calls to make us deliver quickly. \n Thanks and regards, \n tw.in team " ;
					//notify customer
					AppCommon::sendEmail( $model->email, $model->name, $subject_email, 
					$content_user, array("order_notification_customer") );
										
					//notify tw team
					AppCommon::sendEmail( Yii::app()->params['adminEmail'], $model->name, $subject_email, 
					$content_user, array("order_notification_tiffinwale.in_team") );
					
					$content_sms = "Dear Customer, we have received your order and it will be delivered".
					" on ".$temp_date_sms." ( +/- 15 min. ). Do check your email for complete details.".
					" Thanks! tw.in";
					/*$content_sms = "Dear Customer, we have received your order and it will be delivered".
					" on 01 Apr 2015 12:00 am. Do check your email for complete details.".
					" Thanks! tw.in";
					$content_sms = "Dear Customer, we have received your order from".
					" and it will be delivered between 12:30 PM to 2:00 PM. Thank You! tw.in";*/
					//sms customer
					AppCommon::sendSmsOnTime( $model->phone, $content_sms, "null", true );
					
					

					Yii::app()->user->setFlash('buy','Thank you for ordering. Kindly check sms on your phone, we will deliver the meal at your address by '.$temp_date.'.' );
					$this->refresh();
				}
			}
			$this->render('buy',array('model'=>$model, 'data'=>$selectedTiffin[0]));
		}
		else 
		{	
			Yii::app()->user->setFlash('buy','Currently this meal is unavailable. Kindly do visit us again tomorrow, during lunch hours.');
			//$this->refresh();			
			$this->render('buy');
		}
	}
	
	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
		$this->loadModel($id)->delete();

		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('ACart');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return ACart the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=ACart::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param ACart $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='acart-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
