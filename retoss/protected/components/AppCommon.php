<?php
/**
 * ApplicationCommon class store those methods which are commonly used by the application
 * author: ankit
 */
class AppCommon
{
	// gets the base url of website
	// return baseurl like from http://abc.com/dex/index.php/cde/ only http://abc.com/dex/index.php 
	//is returned
	public static function getSiteBaseUrl( )
	{
		return Yii::app()->getRequest()->getHostInfo().Yii::app()->getRequest()->getScriptUrl();
	}
	
	// gets the path of app folder
	// return if app resides in some internal folder in server 
	//http://abc.com/dex/appfolder/index.php/cde/ then 
	//http://abc.com/dex/appfolder/ is returned 
	public static function getAppFolderUrl( )
	{
		return Yii::app()->getRequest()->getBaseUrl(true);
	}
	
	// gets the login id of currently logged in user
	// return id if user is logged in otherwise false
	public static function getUserLoginId( )
	{
		//userloginid_userdetailsid is stored in id seperated by a underscore.
		if( Yii::app()->user->isGuest )
			return false;
		$id = Yii::app()->user->getId();
		$pos = strpos( $id, "_");
		if( $pos !== false )
		{
			return substr( $id , 0, $pos);
		}	
		else
			return false;
	} 
	
	// gets the user details id of currently logged in user
	// return id if user is logged in otherwise false
	public static function getUserDetailsId( )
	{
		//userloginid_userdetailsid is stored in id seperated by a underscore.
		if( Yii::app()->user->isGuest )
			return false;
		$id = Yii::app()->user->getId();
		$pos = strpos( $id, "_");
		if( $pos !== false )
		{
			return substr( $id , $pos + 1 );
		}	
		else
			return false;		
	} 
		
	// gets the user type of currently logged in user
	// return id if user is logged in otherwise false
	public static function getUserType( )
	{
		if( Yii::app()->user->isGuest )
			return false;
		$states = Yii::app()->user->getState( CWebUser::STATES_VAR);
		if( $states["userType"] )
			return Yii::app()->user->getState( "userType" );
		else 
			return false;		
	} 	
		
	// gets the user role of currently logged in user
	// return id if user is logged in otherwise false
	public static function getUserRole( )
	{
		//role to user type mapping can be done using db table too. currently its written here in roleMap array
		if( Yii::app()->user->isGuest )
			return false;
		$userType = AppCommon::getUserType();
		if( $userType !== false )
		{
			$roleMap = array(
				"0" => "customer",
				"1" => "seller",
				"2" => "moderator",
				"3" => "administrator",
			);
			return $roleMap[ $userType ];
		}
		else 
			return false;
	} 	
		
	// gets the email of currently logged in user
	// return id if user is logged in otherwise false
	public static function getEmail( )
	{
		if( Yii::app()->user->isGuest )
			return false;
		$states = Yii::app()->user->getState( CWebUser::STATES_VAR);
		if( $states["email"] )
			return Yii::app()->user->getState( "email" );
		else 
			return false;
		
	} 	
		
	// sends email 
	//TODO support different email service provider besides mandrill
	// return 
	public static function sendEmail( $toEmail, $toName, $subject, $content, $tags = null )
	{
		try {
				$mandrill = new Mandrill( Yii::app()->params['mandrillApiKey'] );
    			$message = array(
        		'html' => null,//'<p>Example HTML content</p>',
        		'text' => $content,
        		'subject' => $subject,
        		'from_email' => 'website@tw.in',
        		'from_name' => 'tw.in website team',
        		'to' => array(
            	array(
                	'email' => $toEmail,
                	'name' => $toName,
                	'type' => 'to'
            		)
        		),
        		'headers' => array('Reply-To' => $toEmail),
        		'important' => true,
        		'track_opens' => true,
        		'track_clicks' => true,
        		'auto_text' => null,
        		'auto_html' => null,
        		'inline_css' => null,
        		'url_strip_qs' => null,
        		'preserve_recipients' => null,
        		'view_content_link' => null,
        		'bcc_address' => null,
        		'tracking_domain' => null,
        		'signing_domain' => null,
        		'return_path_domain' => null,
        		'merge' => true,
        		'merge_language' => 'mailchimp',
        		'global_merge_vars' => null,
        		'merge_vars' => null,
        		'tags' => $tags,
        		'subaccount' => null,
        		'google_analytics_domains' => null,
        		'google_analytics_campaign' => null,
        		'metadata' => array('website' => 'www.tw.in'),
        		'recipient_metadata' => array(
            		array(
                		'rcpt' => $toEmail,
                		'values' => null
            		)
        		),
        		'attachments' => null,
        		'images' => null
    			);
    			$async = false;
    			$ip_pool = 'default';
    			$send_at = null;
    			$result = $mandrill->messages->send($message, $async, $ip_pool, $send_at);
				Yii::ankFileSave( var_export( $result ,true));
			} 
			catch(Mandrill_Error $e) 
			{
    			// Mandrill errors are thrown as exceptions
    			Yii::ankFileSave( 'A mandrill email error occurred: ' . get_class($e) . ' - ' . $e->getMessage() );
				Yii::ankFileSave( $toEmail );
				Yii::ankFileSave( $toName );
				Yii::ankFileSave( $subject );
				Yii::ankFileSave( $content );
			}
	} 	
	
	// sends sms on given time 
	//Format: YYYY-MM-DD HH:MM:SS OR YYYY-MM-DD HH:MM AM/PM
	//2014-08-26 04:45pm
	//TODO support different email service provider besides springedge
	// return 
	public static function sendSmsOnTime( $toPhone, $message, $time = "null", $isSecure = true )
	{
		try 
		{
			$url = null;
			if( $isSecure )
				$url = Yii::app()->params['springedgeSecuredUrl'];
			else
				$url = Yii::app()->params['springedgeUrl'];
				
			$sendsms=new sendsms( $url, Yii::app()->params['springedgeApiKey'],
				 Yii::app()->params['springedgeSenderId']);
			$xmlResponse = $sendsms->schedule_sms( $toPhone, $message, "", "json", $time);//json argument
			// is changed to xml downstream
			Yii::ankFileSave( 'A springedge sms response=>'.$toPhone.'=>'.$message );
			Yii::ankFileSave( $xmlResponse );
		} 
		catch(Exception $e) 
		{
			Yii::ankFileSave( 'A springedge sms error occurred: ' . ' - ' . $e->getMessage() );
		}
	}
	
	//cart section- start
	public static $cartErrorMsgTiffinNotExist = "This tiffin does not exists. So, it has been removed from the cart.";
	public static $cartErrorMsgTiffinNotAvailable = "Currently, this tiffin is not available. So, it has been removed from the cart.";
	public static $cartErrorMsgTiffinQuanCappedToLimits = "The selected quantity is not in limits. So, it has been capped to the limits.";
	public static $cartErrorMsgTiffinNotAvailableInCurrLocality = "This tiffin is not available at selected locality.";
		
	/**
	 * merges cookies and db cart if logged in.
	 */
	public static function mergeCookieAndDbCart( )
	{
		$allCookies = Yii::app()->request->getCookies();
		if( !(Yii::app()->user->isGuest) )
		if( isset( $allCookies[ Yii::app()->params['cartCookieName'] ] ) )
		{
			$cartCookiesArr = array();
			$cartCookiesArr = CJSON::decode( $allCookies[ Yii::app()->params['cartCookieName'] ]->value
			, true );
			$alreadyPresentRecord = ACart::model()->findAll( array(
        			'condition'=>'is_deleted = "no" AND cart2user = '.AppCommon::getUserDetailsId(),
    				) 
				);
			foreach( $alreadyPresentRecord as $currRec )
			{
				if( isset( $cartCookiesArr[ $currRec->cart2tiffin ] ) )
				{
					$currRec->quantity = $currRec->quantity + $cartCookiesArr[ $currRec->cart2tiffin ][ 0 ];
					$currRec->save();
					unset( $cartCookiesArr[ $currRec->cart2tiffin ] );
				}
			}
			
			foreach ($cartCookiesArr as $key => $value) 
			{ 
				if( $value[ 0 ] > 0 )//if quantity is more than 0
				{
					try//added as cart2tiffin is foriegn key and $id can be any garbage value so it can error out
					{
						$model=new ACart;
						$model->cart2tiffin = $key;
						$model->cart2user = AppCommon::getUserDetailsId();
						$model->quantity = $value[ 0 ];
						$model->added_time = $value[ 1 ];
						$model->save();
					}
					catch( Exception $e )
					{
						//Yii::ankFileSave( $e->getMessage());//ankit
						$ignored = true;//added to ignore exception
					}
				}
			}
			
			unset( $allCookies[ Yii::app()->params['cartCookieName'] ] );
		}
	} 
		
	/**
	 * get number of items in cart.
	 */
	public static function cartItemCount( )
	{
		$response = 0;
		if( Yii::app()->user->isGuest )//saved in cookie
		{
			$allCookies = Yii::app()->request->getCookies();
			$cartCookiesArr = array();
			if( isset( $allCookies[ Yii::app()->params['cartCookieName'] ] ) )
			{
				$cartCookiesArr = CJSON::decode( $allCookies[ Yii::app()->params['cartCookieName'] ]->value
				, true );
			}
			if( isset( $cartCookiesArr ) )
			foreach ($cartCookiesArr as $key => $value) 
			{
				$response = $response + $value[ 0 ];
			}
		}
		else //saved in db
		{				
			$sql = 'SELECT SUM( quantity ) FROM a_cart WHERE 
			is_deleted = "no" AND cart2user = '.AppCommon::getUserDetailsId().';';	
			$list= Yii::app()->db->createCommand( $sql )->queryAll();
			if( isset( $list[ 0 ]['SUM( quantity )'] ) )	//not null
				$response = $list[ 0 ]['SUM( quantity )'];
		}
		return $response;
	}
	
	/**
	 * check if cart has changed. if locality is set in input array then it checks the
	 * change w.r.t the locality otherwise it checks complete cart
	 * return false if cart has not changed true for every thing else
	 */
	public static function hasCartChanged( $cartArray = null )
	{
		$response = true;
		if( isset( $cartArray ) )
		{
			if( isset( $cartArray["location"] ) )//location exists
			{
				$response = false;
				foreach ($cartArray as $key => $value) 
				{
					if( is_array( $value ) )//to filter only values having tiffin info
					{
						if( $value[ "is_available_at_current_locality" ] )
							if( $value[ "has_changed" ] )
							{
								$response = $value[ "has_changed" ];
								break;
							}
						
					} 
				}
			}
			else//location does not exists
			{
				if( isset( $cartArray["has_changed"] ) )
					$response = $cartArray[ "has_changed" ];
			}
		}
		return $response;
	}
			
	/**
	 * takes the given array and respond with changed array which contains proper quantity of every tiffin
	 * plus some message is given with the tiffin quantity row.
	 * reponse array has 'total_price' as total cart price and 'has_changed' over all and per tiffin row to depict 
	 * if cart has changed like quantity has been changed
	 * or tiffins have been removed. Example row below
	 * tiffn_id=>array("has_changed"=>true,"id"=>xyz,"tiffin_name"=>xyz,"tiffin_content"=>xyz,"image_link"=>xyz,"delivery_time"=>xyz
	 * , 'quantity'=> xyz, "per_unit_price"=> xyz,"error_msg"=>xyz )
	 * error_msg exists when row's has_changed is true and if has_changed is false error_msg does not exists
	 */
	public static function modifyInputTiffinsQuantity( $tiffinAndQuantArr, $location = null )
	{
		$response = array();
		$response[ "has_changed" ] = false;//made true if a change is array data is made
		$response[ "total_price" ] = 0;
		$response["total_items_at_locality"] = 0;
		$tiffinIdSqlInCondtStr = ATiffin::model()->getCommandBuilder()->createInCondition(ATiffin::model()->tableName(),
		 'id', array_keys( $tiffinAndQuantArr ),'t.');//string containing IN condition
		$selectedTiffins = array();
		$currDateTime = new DateTime();
		$currDateTime = $currDateTime->format('Y-m-d H:i:s');
		if( isset( $location ) )
		{
			$selectedTiffins= ATiffin::model()->findAll( array(
    				'select'=>'t.id, t.name, t.contents, t.rating_of_tiffin, t.num_of_reviews, t.image',
        			'condition'=>'t.verified_by != "not verified" AND t.is_deleted = "no" AND '.$tiffinIdSqlInCondtStr,
        			'order'=> 't.id, aPriceTimes.order_delivery_time ASC' ,//added to keep fastest delivery row on top at index 0
	        		'with'=>
    	    		array(
        			'tiffin2userDetails'=>
        				array(
        				'select'=>'tiffin2userDetails.id, tiffin2userDetails.first_name, tiffin2userDetails.last_name, 
        				 tiffin2userDetails.rating_of_tiffinwala, tiffin2userDetails.unique_name',
        				'on'=>'tiffin2userDetails.is_active=1 AND tiffin2userDetails.user_type = 1',
        				'with'=>
        				array(
        				'aBangaloreLocalities'=>
        					array(
        					//'select'=>false,
        					'on'=>'aBangaloreLocalities.is_deleted = "no" AND aBangaloreLocalities.locality_name='.'"'.$location.'"',
        					//'condition'=>'aBangaloreLocalities.is_deleted = "no" ',	
        					'joinType'=>'LEFT OUTER JOIN'
    							),        				
							),
    						),
	    			'aPriceTimes'=>
    	    			array(
    	    			'select'=>'aPriceTimes.price_after_discount, aPriceTimes.order_end_time, 
    	    					aPriceTimes.order_delivery_time, aPriceTimes.quantity_currently_available, 
    	    					aPriceTimes.orderType, aPriceTimes.discount',
						'on'=>'aPriceTimes.order_start_time <= '.'"'.$currDateTime.'"'.
						' AND aPriceTimes.order_end_time >= '.'"'.$currDateTime.'"'.
						' AND aPriceTimes.order_delivery_time >= '.'"'.$currDateTime.'"'.
						' AND aPriceTimes.quantity_currently_available > 0 '.
						'AND aPriceTimes.verified_by != "not verified" AND aPriceTimes.is_deleted = "no"',	
        				'joinType'=>'LEFT OUTER JOIN'
							),
	    			//'aPhotoses'=>
    	    		//	array(
    	    		//	'select'=>'aPhotoses.photo_path',
        			//	'on'=>'aPhotoses.is_deleted = "no" and aPhotoses.meta_data = "profile"',	
					//		),
						),
    				) );
		}
		else 
		{
			$selectedTiffins= ATiffin::model()->findAll( array(
    				'select'=>'t.id, t.name, t.contents, t.rating_of_tiffin, t.num_of_reviews, t.image',
        			'condition'=>'t.verified_by != "not verified" AND t.is_deleted = "no" AND '.$tiffinIdSqlInCondtStr,
        			'order'=> 't.id, aPriceTimes.order_delivery_time ASC' ,//added to keep fastest delivery row on top at index 0
	        		'with'=>
    	    		array(
        			'tiffin2userDetails'=>
        				array(
        				'select'=>'tiffin2userDetails.id, tiffin2userDetails.first_name, tiffin2userDetails.last_name, 
        				 tiffin2userDetails.rating_of_tiffinwala, tiffin2userDetails.unique_name',
        				'on'=>'tiffin2userDetails.is_active=1 AND tiffin2userDetails.user_type = 1',
    						),
	    			'aPriceTimes'=>
    	    			array(
    	    			'select'=>'aPriceTimes.price_after_discount, aPriceTimes.order_end_time, 
    	    					aPriceTimes.order_delivery_time, aPriceTimes.quantity_currently_available, 
    	    					aPriceTimes.orderType, aPriceTimes.discount',
						'on'=>'aPriceTimes.order_start_time <= '.'"'.$currDateTime.'"'.
						' AND aPriceTimes.order_end_time >= '.'"'.$currDateTime.'"'.
						' AND aPriceTimes.order_delivery_time >= '.'"'.$currDateTime.'"'.
						' AND aPriceTimes.quantity_currently_available > 0 '.
						'AND aPriceTimes.verified_by != "not verified" AND aPriceTimes.is_deleted = "no"',	
        				'joinType'=>'LEFT OUTER JOIN'
							),
	    			//'aPhotoses'=>
    	    		//	array(
    	    		//	'select'=>'aPhotoses.photo_path',
        			//	'on'=>'aPhotoses.is_deleted = "no" and aPhotoses.meta_data = "profile"',	
					//		),
						),
    				) );
			
		}
		
		foreach( $selectedTiffins as $currRec )
		{
			if( isset( $tiffinAndQuantArr[ $currRec->id ] ) )
			{				
				$response[ $currRec->id ][ "has_changed" ] = false;
				if( isset( $location ) and ! isset( $currRec->tiffin2userDetails->aBangaloreLocalities[ 0 ] ) )
				{
					$response[ $currRec->id ][ "is_available_at_current_locality" ] = false;
				}
				else 
				{
					$response[ $currRec->id ][ "is_available_at_current_locality" ] = true;
				}
				if( isset( $currRec->aPriceTimes[ 0 ] )  and $currRec->aPriceTimes[ 0 ]->quantity_currently_available > 0)
				//if pricetime exists and quantity is more than zero then tiffin is available
				{					
					if( $tiffinAndQuantArr[ $currRec->id ] < 1 )//if current quan is less than 1
					{
						$tiffinAndQuantArr[ $currRec->id ] = 1;
						$response[ "has_changed" ] = true;
						$response[ $currRec->id ][ "has_changed" ] = true;
						$response[ $currRec->id ][ "error_msg" ] = AppCommon::$cartErrorMsgTiffinQuanCappedToLimits;
						$response[ $currRec->id ][ "quantity" ] = $tiffinAndQuantArr[ $currRec->id ];
						$response[ $currRec->id ][ "per_unit_price" ] = $currRec->aPriceTimes[ 0 ]->price_after_discount;
						$response[ $currRec->id ][ "delivery_time" ] = 
						AppCommon::getDetailedDateString( $currRec->aPriceTimes[ 0 ]->order_delivery_time );	
					}
					//if current quan is more than 1
					else if( $tiffinAndQuantArr[ $currRec->id ] > $currRec->aPriceTimes[ 0 ]->quantity_currently_available )
					{
						$tiffinAndQuantArr[ $currRec->id ] = $currRec->aPriceTimes[ 0 ]->quantity_currently_available;
						$response[ "has_changed" ] = true;
						$response[ $currRec->id ][ "has_changed" ] = true;
						$response[ $currRec->id ][ "error_msg" ] = AppCommon::$cartErrorMsgTiffinQuanCappedToLimits;
						$response[ $currRec->id ][ "quantity" ] = $tiffinAndQuantArr[ $currRec->id ];
						$response[ $currRec->id ][ "per_unit_price" ] = $currRec->aPriceTimes[ 0 ]->price_after_discount;
						$response[ $currRec->id ][ "delivery_time" ] = 
						AppCommon::getDetailedDateString( $currRec->aPriceTimes[ 0 ]->order_delivery_time );
					}
					else//everything is alright
					{
						$response[ $currRec->id ][ "quantity" ] = $tiffinAndQuantArr[ $currRec->id ];
						$response[ $currRec->id ][ "per_unit_price" ] = $currRec->aPriceTimes[ 0 ]->price_after_discount;
						$response[ $currRec->id ][ "delivery_time" ] = 
						AppCommon::getDetailedDateString( $currRec->aPriceTimes[ 0 ]->order_delivery_time );	
					}
					
					if( $response[ $currRec->id ][ "is_available_at_current_locality" ] )
					{
						$response["total_items_at_locality"] = $response["total_items_at_locality"] + 
						$response[ $currRec->id ][ "quantity" ];
						$response[ "total_price" ] = $response[ "total_price" ] + 
							( $response[ $currRec->id ][ "quantity" ] * $response[ $currRec->id ][ "per_unit_price" ] );
					}
				}
				else //tiffin is not available at given time or the current quantity is zero 
				{
					$response[ "has_changed" ] = true;
					$response[ $currRec->id ][ "has_changed" ] = true;
					$response[ $currRec->id ][ "error_msg" ] = AppCommon::$cartErrorMsgTiffinNotAvailable;
				}				
				$imagePath = null;
				$response[ $currRec->id ][ "id" ] = $currRec->id;
				$response[ $currRec->id ][ "tiffin_name" ] = $currRec->name;
				$response[ $currRec->id ][ "tiffin_content" ] = $currRec->contents;
				$response[ $currRec->id ][ "chef_id" ] = $currRec->tiffin2userDetails->id;
				
				if( isset( $currRec->image ) )
					$imagePath = AppCommon::getAppFolderUrl().'/images/tiffin_images/'.$currRec->image;
				else
					$imagePath = AppCommon::getAppFolderUrl().'/images/tiffin_images/5.jpg';//default image
				
				$response[ $currRec->id ][ "image_link" ] = $imagePath;
				
				unset( $tiffinAndQuantArr[ $currRec->id ] );
			}
		}
			
		foreach ($tiffinAndQuantArr as $key => $value) //tiffin for given id does not exists
		{ 
					$response[ "has_changed" ] = true;
					$response[ $key ][ "has_changed" ] = true;
					$response[ $key ][ "error_msg" ] = AppCommon::$cartErrorMsgTiffinNotExist;	
		}
		
		//$response["total_items"] = AppCommon::cartItemCount( );
		$response["location"] = $location;
		
		return $response;
	}
	
	//cart section- stop
	
	// convert Y-m-d H:i:s date format to detailed one like 2015-Jun-06 Saturday, 11:00:00 pm 
	//returns blank string "" if error
	public static function getDetailedDateString( $inputDate )
	{
		$temp_date1 = DateTime::createFromFormat( 'Y-m-d H:i:s', $inputDate );
		if( $temp_date1 !=FALSE)
		{
        	return ($temp_date1->format('Y-M-d l, h:i:s a'));
        }
		else 
		{
			return " ";
		}
	}
		
	// ideally this function should be atomic and only one thread should be allowed in it at a time and
	//it should give a different order id on every call
	//however, this is not ideal :( few race conditions can make system inconsistent or behave abnormally
	//but still it is pretty good
	//returns unique order number for a user if user is not logged in it will return false
	public static function getUniqueOrderNumForUser( $userDetailsId )
	{
		$response = false;
		if( isset( $userDetailsId ) && $userDetailsId )
		{
			$userRec = AUserDetails::model()->findAll( array(
			'select'=>'t.unique_name',
        	'condition'=>'t.id = '.$userDetailsId.' AND t.is_deleted = "no"',
			)
			);
			if( count( $userRec ) > 0 )
			{
				$response = $userRec[ 0 ]->unique_name;
			}
			else 
			{
				return $response;
			}
			
			//gets count of total different type of order_unique_id used till
			//in short, gets number of orders made by users till now
			//could not use GROUP BY because
			//http://stackoverflow.com/questions/3597577/return-count-0-with-mysql-group-by
			$sql = 'SELECT COUNT( DISTINCT order_unique_id ) FROM a_order WHERE 
			is_deleted = "no" AND ordered_by2user_details = '.$userDetailsId.
			' ;';	
			$list= Yii::app()->db->createCommand( $sql )->queryAll();
			if( isset( $list[ 0 ]['COUNT( DISTINCT order_unique_id )'] ) )	//not null
				$response = $response.'X'.( $list[ 0 ]['COUNT( DISTINCT order_unique_id )'] + 1 );//quickfix for url breaking in sms
				//$response = $response.'('.( $list[ 0 ]['COUNT( DISTINCT order_unique_id )'] + 1 ).')';
		}
		return $response;
	}
		
	//get base address data for a user t.meta_data = "base_address"
	//returns base address data array( addrId => array( locality, addrText ) ) for a user 
	//return false if not found
	public static function getBaseAddressDataForUser( $userDetailsId )
	{
		$response = array();
		if( isset( $userDetailsId ) )
		{
			$selectedAddresses = AAddress::model()->findAll( array(
					'order'=> 't.id DESC' ,
	        		'with'=>
    	    		array(
        			'address2bangaloreLocalities'=>
    	    			array(
        				'on'=>'address2bangaloreLocalities.is_deleted = "no" AND 
        				t.is_deleted = "no" AND t.link_table = "user_details"  AND 
        				t.meta_data = "base_address" AND t.link = '.$userDetailsId.' ',	
							),
						),
    				) );
			foreach ( $selectedAddresses as $row ) 
			{
				$response[ $row->id ][] = $row->address2bangaloreLocalities->locality_name;
				$response[ $row->id ][] = $row->getAddressString( );
				break; //get the last updated and exit
			}
		}
		
		if( AppCommon::isEmpty( $response ) )
			$response = false;
		return $response;
	}
		
	//get email and base phone number for a user t.meta_data = "base_phone"
	//returns array( 'email' => email, 'phone' => phone ) for a user 
	//return false if not found
	public static function getEmailAndBasePhoneNumForUser( $userDetailsId )
	{
		$response = array();
		if( isset( $userDetailsId ) )
		{
			$selectedRec = AUserDetails::model()->findAll( array(
				'with'=>
    	    			array(
        				'aUserLogins'=>
    	    				array(
        					'on'=>'aUserLogins.is_deleted = "no" AND 
        					 t.is_deleted = "no" AND t.id = '.$userDetailsId.' ',	
								),
							),
			));
			foreach ( $selectedRec as $row ) 
			{
				$response[ 'email' ] = $row->aUserLogins[0]->login_name;
				break; //get the last updated and exit
			}
			
			
			$selectedPhone = APhone::model()->findAll( array(
					'order'=> 't.id DESC' ,
        			'condition'=>'t.is_deleted = "no" AND t.link_table = "user_details"  AND 
        				t.meta_data = "base_phone" AND t.link = '.$userDetailsId.' ',	
    				) );
			foreach ( $selectedPhone as $row ) 
			{
				$response[ 'phone' ] = $row->phone_num;
				break; //get the last updated and exit
			}
		}
		
		if( AppCommon::isEmpty( $response ) )
			$response = false;
		return $response;
	}

	//gets allowed APriceTime object for given Tiffin and quantity with ascending delivery time
	//return empty array if not found
	public static function getAllowedAPriceTimeObjForGivenTiffinAndQuantity( $tiffinId, $quantity )
	{
		$response = array();
		$currDateTime = new DateTime();
		$currDateTime = $currDateTime->format('Y-m-d H:i:s');
		$selectedRecords = null;
		if( isset( $tiffinId ) && isset( $quantity ) )
		{
			$selectedRecords = APriceTime::model()->findAll( array(
				'order'=> 't.order_delivery_time, t.id' ,
        		'condition'=>'t.is_deleted = "no" AND t.verified_by != "not verified"  AND t.price_time2tiffin = '.$tiffinId.
        				' AND  t.quantity_currently_available >= '.$quantity.
        				' AND t.order_start_time <= '.'"'.$currDateTime.'"'.
						' AND t.order_end_time >= '.'"'.$currDateTime.'"'.
						' AND t.order_delivery_time >= '.'"'.$currDateTime.'" ',	
			));
		}
		
		if( isset( $selectedRecords ) )
			$response = $selectedRecords;
		return $response;
	}

	//create and saves order history record
	//caller is responsible for exception handling 
	//return id of order
	public static function createOrderHistoryRecord( $orderId, $status, $dateTime, $comments )
	{
		//saved order history record
		$orderHistoryRec = new AaOrderHistory();
		$orderHistoryRec->order_history2order = $orderId;
		$orderHistoryRec->status = $status;
		$orderHistoryRec->time = $dateTime;
		$orderHistoryRec->comments = $comments;
		$orderHistoryRec->save();
		
		return $orderHistoryRec->id;
	}

	/**
	 * Checks if the given value is empty.
	 * A value is considered empty if it is null, an empty array, or the trimmed result is an empty string.
	 * Note that this method is different from PHP empty(). It will return false when the value is 0.
	 * @param mixed $value the value to be checked
	 * @param boolean $trim whether to perform trimming before checking if the string is empty. Defaults to false.
	 * @return boolean whether the value is empty
	 */
	public static function isEmpty($value,$trim=false)
	{
		return $value===null || $value===array() || $value==='' || $trim && is_scalar($value) && trim($value)==='';
	}

}