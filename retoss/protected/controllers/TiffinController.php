<?php

class TiffinController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';
	//public $layout='//layouts/column3';

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
			array('allow',  // allow all users to perform 'index' and 'view' actions
				'actions'=>array('index','view'),
				'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('create','update', 'GetPriceTimeUI' ),
				'users'=>array('@'),
				'roles'=>array('seller','moderator','administrator'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('delete'),
				'users'=>array('@'),
				'roles'=>array('seller','moderator','administrator'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('admin',),
				'users'=>array('@'),
				'roles'=>array('moderator','administrator'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id)
	{
		$id = '-'.$id;//extracting id from url
		$id = substr( $id , ( strrpos( $id, '-' ) + 1 ) );//extracting id from url
		$this->render('view',array(
			'model'=>$this->loadModel($id, ' is_deleted = "no" '),
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new ATiffin;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['ATiffin']))
		{
			$model->attributes=$_POST['ATiffin'];
			$model->tiffin2user_details=Yii::app()->user->getId();
			$model->tiffin2user_details=substr($model->tiffin2user_details,
				strpos($model->tiffin2user_details,'_') + 1);
			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
		}

		$this->render('create',array(
			'model'=>$model,
		));
	}

	/**
	 * gets the UI for price time ui adds id value as [id]
	 * $index serial number/// mandatory field
	 * $model APriceTime object 
	 */
	public function actionGetPriceTimeUI( $index, $model = null )
	{
		if( $model === null )
			$model = new APriceTime;
		
		$currDatetime = new DateTime();
		$currDatetime = $currDatetime->format('Y-m-d H:i:s');
		
		if( Yii::app()->getRequest()->getIsAjaxRequest() )
		{
			Yii::app()->getClientScript()->enableRenderingForAjaxResponse = true;
			Yii::app()->getClientScript()->bannedCoreScripts[] = 'jquery';
			$html_code	=	$this->renderPartial('_priceTimeForm', array(
            		'model' => $model,
            		'index' => $index,
            		'display' => 'block',
            		'today' => $currDatetime,
        		), true, true);
			$ajaxResponse = Yii::app()->getClientScript()->returnScriptStore();
			$ajaxResponse[ "html_code" ] = $html_code;
			Yii::app()->getClientScript()->bannedCoreScripts = array();
			Yii::app()->getClientScript()->enableRenderingForAjaxResponse = false;
			echo CJSON::encode( $ajaxResponse );
			return;
		}
		
		$this->renderPartial('_priceTimeForm', array(
            'model' => $model,
            'index' => $index,
            'display' => 'block',
            'today' => $currDatetime,
        ), false, false);
        //making last argument true sends script tags to client which error out some JS code-ankit
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		$model=$this->loadModel($id, //' quantity_available = initial_quantity and 
		'is_deleted = "no" and 
		tiffin2user_details = '.AppCommon::getUserDetailsId());//loading record only if owner of record id opening it
		//quantity_available = initial_quantity maintains that order has not been made on this record
		//as ordered record must not be changed( except quantity change in limits) or deleted
		
		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['ATiffin']))
		{
			$model->attributes=$_POST['ATiffin'];
			if(isset($_POST['APriceTime']))
			{
				foreach ($_POST['APriceTime'] as  $value) 
				{
					//Yii::ankFileSave( $key );
					Yii::ankFileSave( $value["time"] );
					Yii::ankFileSave( $value["price"] );
					Yii::ankFileSave( $value["discount"] );
				}
			}
			//if($model->save())
				$this->redirect(array('view','id'=>$model->id));
		}

		$this->render('update',array(
			'model'=>$model,
		));
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
	 * makes an argument array from string.
	 * location=abc,xyz|date-start=2014-09-25 00:59:20|date-end=2014-09-26 00:59:20|tags=spicy,punjabi|chefs=abc,dce|discount=yes|sort=rating
	 */
	public function getArgumentsFromString( $filters = null )
	{
		if($filters == null)
			return null;
		$temp1 = explode( "|", $filters );
		$response = array();
		foreach($temp1 as $value) 
		{
			$pos = strpos( $value, '=');
			$lhs = substr( $value, 0, $pos );
			$rhs = substr( $value, $pos + 1 );
			$rhs = explode( ",", $rhs );
			$response[$lhs] = $rhs;
		}
		if( ! isset($response['sort']) )
		{
			$response['sort'] = array('price increasing');
		}
		if( ! isset($response['location']) )
		{
			$response['location'] = array(' ');
		}
		
		$date_s = FALSE;
		$date_e = FALSE;
		
		if( isset($response['date-start']) )
			$date_s = DateTime::createFromFormat('Y-m-d H:i:s', $response['date-start'][0]);
		
		if( isset($response['date-end']) )			
			$date_e = DateTime::createFromFormat('Y-m-d H:i:s', $response['date-end'][0]);
		
		if( $date_s == FALSE )
		{
			$date_s = new DateTime();
			//$date_s = $date_s->sub(new DateInterval('PT2H'));//decrease current time by 2 hours---quick fix
		}		
		if( ( $date_e == FALSE ) or  ( $date_e <= $date_s ) )
		{
			$date_e = clone $date_s;
			$date_e = $date_e->add(new DateInterval('P2D'));//increase by 2 day
		}
		
		$response['date-start'][0] = $date_s->format('Y-m-d H:i:s') ;
		$response['date-end'][0] = $date_e->format('Y-m-d H:i:s') ;	
		
		//Yii::ankFileSave( var_export($response,true));
		
		return $response;
	}

	public function getOrderByString( $sort )
	{
		switch ($sort) 
		{
    		case "rating":
        		$response = '( CASE WHEN aPriceTimes.quantity_currently_available = 0 THEN 0 ELSE 1 END) DESC,
        			t.rating_of_tiffin DESC, aPriceTimes.order_delivery_time ASC,
        			aPriceTimes.order_end_time ASC, aPriceTimes.price_after_discount DESC';
        		break;
    		case "delivery time increasing":
        		$response = '( CASE WHEN aPriceTimes.quantity_currently_available = 0 THEN 0 ELSE 1 END) DESC,
        			aPriceTimes.order_delivery_time ASC, t.rating_of_tiffin DESC, 
        			aPriceTimes.order_end_time ASC, aPriceTimes.price_after_discount DESC';
        		break;
    		case "delivery time decreasing":
        		$response = '( CASE WHEN aPriceTimes.quantity_currently_available = 0 THEN 0 ELSE 1 END) DESC,
        			aPriceTimes.order_delivery_time DESC, t.rating_of_tiffin DESC,
        			aPriceTimes.order_end_time ASC, aPriceTimes.price_after_discount DESC';
        		break;
    		case "price increasing":
        		$response = '( CASE WHEN aPriceTimes.quantity_currently_available = 0 THEN 0 ELSE 1 END) DESC,
        			aPriceTimes.price_after_discount ASC, aPriceTimes.order_delivery_time ASC,
        			t.rating_of_tiffin DESC, aPriceTimes.order_end_time ASC';
        		break;
    		case "price decreasing":
        		$response = '( CASE WHEN aPriceTimes.quantity_currently_available = 0 THEN 0 ELSE 1 END) DESC,
        			aPriceTimes.price_after_discount DESC, aPriceTimes.order_delivery_time ASC,
        			t.rating_of_tiffin DESC, aPriceTimes.order_end_time ASC';
        		break;
		}
		if( isset( $response ) )
			return $response.', t.id ASC, aPriceTimes.id ASC';
		else 
			return ' t.id ASC, aPriceTimes.id ASC';
	}
	
	public function getConditionString( $arr, $alias, $operator =' OR ' )
	{
		$response= "";
		if( $arr )
		{
			$response = $response.'(';
			foreach ($arr as $value) 
			{
				$response = $response.$alias.' = '.'"'.$value.'"'.$operator;
			}
			$response = $response.$alias.' = '.'"'.$arr[0].'"'.')';
		}
		return $response;
	}	
	
	//sent the string and array with strings which need to be removed
	public function sanitizeInputString( $input, $remove = array("\"", "'", "`") )
	{
		$response = $input;
		foreach( $remove as $key )
			$response = implode( explode( $key, $response) );
		$response = strtolower( $response );//lower case the alphabetss
		return $response;
	}
	
	/**
	 * Lists all models.
	 * location=abc,xyz|date-start=2014-09-25 00:59:20|date-end=2014-09-26 00:59:20|tags=spicy,punjabi|chefs=c1,c2|sort=rating
	 */
	public function actionIndex( $filters )
	{
		$currDateTime = new DateTime();
		$currDateTime = $currDateTime->format('Y-m-d H:i:s');
		$filters = $this->sanitizeInputString( $filters );
		$arrayArgs = $this->getArgumentsFromString( $filters );
		$orderByString = $this->getOrderByString( $arrayArgs['sort'][0] );
		$tagsCondition = "";
		$chefsCondition = "";
		if( isset( $arrayArgs['tags'] ) )
			$tagsCondition = $this->getConditionString( $arrayArgs['tags'], 'aFoodTags.tag_name' );
		if( isset( $arrayArgs['chefs'] ) )
			$chefsCondition = $this->getConditionString( $arrayArgs['chefs'], 'tiffin2userDetails.unique_name' );
		$selectedTiffins = null;
		
		$modelArr=ABangaloreLocalities::model()->findAll('is_deleted = "no"');
		$locality_arr= array();
		foreach( $modelArr as $singleModel)
		{
			$locality_arr[ strtolower( $singleModel->locality_name ) ] = strtolower ( $singleModel->locality_name );
		}
		
		if( $tagsCondition != '')
		{
			$selectedTiffins= ATiffin::model()->findAll( array(
    				'select'=>'t.id, t.name, t.contents, t.rating_of_tiffin, t.num_of_reviews, t.image',
        			'condition'=>'t.verified_by != "not verified" AND t.is_deleted = "no"',
        			'order'=> $orderByString ,
	        		'with'=>
    	    		array(
        			'tiffin2userDetails'=>
        				array(
        				'select'=>'tiffin2userDetails.id, tiffin2userDetails.first_name, tiffin2userDetails.last_name, 
        				 tiffin2userDetails.rating_of_tiffinwala, tiffin2userDetails.unique_name',
        				'on'=>'tiffin2userDetails.is_active=1 AND tiffin2userDetails.user_type = 1',
        				'condition'=>$chefsCondition,
        				'with'=>
        				array(
        				'aBangaloreLocalities'=>
        					array(
        					'select'=>false,
        					'on'=>'aBangaloreLocalities.locality_name='.'"'.$arrayArgs['location'][0].'"',
        					'condition'=>'aBangaloreLocalities.is_deleted = "no" ',
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
						' AND aPriceTimes.order_delivery_time >= '.'"'.$arrayArgs['date-start'][0].'"'.
						' AND aPriceTimes.order_delivery_time <= '.'"'.$arrayArgs['date-end'][0].'"',
        				'condition'=>'aPriceTimes.verified_by != "not verified" AND aPriceTimes.is_deleted = "no"',	
							),
	    			'aFoodTags'=>
    	    			array(
        				'select'=>false,
						'on'=>$tagsCondition,
        				'condition'=>'aFoodTags.is_deleted = "no"',	
							),
	    			'aFoodTagsAll'=>
    	    			array(
    	    			'select'=>'aFoodTagsAll.tag_name',
        				'on'=>'aFoodTagsAll.is_deleted = "no"',	
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
        			'condition'=>'t.verified_by != "not verified" AND t.is_deleted = "no"',
        			'order'=> $orderByString ,
	        		'with'=>
    	    		array(
        			'tiffin2userDetails'=>
        				array(
        				'select'=>'tiffin2userDetails.id, tiffin2userDetails.first_name, tiffin2userDetails.last_name, 
        				 tiffin2userDetails.rating_of_tiffinwala, tiffin2userDetails.unique_name',
        				'on'=>'tiffin2userDetails.is_active=1 AND tiffin2userDetails.user_type = 1',
        				'condition'=>$chefsCondition,
        				'with'=>
        				array(
        				'aBangaloreLocalities'=>
        					array(
        					'select'=>false,
        					'on'=>'aBangaloreLocalities.locality_name='.'"'.$arrayArgs['location'][0].'"',
        					'condition'=>'aBangaloreLocalities.is_deleted = "no" ',
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
						' AND aPriceTimes.order_delivery_time >= '.'"'.$arrayArgs['date-start'][0].'"'.
						' AND aPriceTimes.order_delivery_time <= '.'"'.$arrayArgs['date-end'][0].'"',
        				'condition'=>'aPriceTimes.verified_by != "not verified" AND aPriceTimes.is_deleted = "no"',	
							),
	    			'aFoodTagsAll'=>
    	    			array(
    	    			'select'=>'aFoodTagsAll.tag_name',
        				'on'=>'aFoodTagsAll.is_deleted = "no"',	
							),
	    			//'aPhotoses'=>
    	    		//	array(
    	    		//	'select'=>'aPhotoses.photo_path',
        			//	'on'=>'aPhotoses.is_deleted = "no" and aPhotoses.meta_data = "profile"',
					//		),
						),
    				) );
		}
		$chefsfiltersArr = $this->getChefsFiltersWithNumbers( $currDateTime, $arrayArgs['date-start'][0], 
			$arrayArgs['date-end'][0], $tagsCondition, $arrayArgs['location'][0] );
		$tagsfiltersArr = $this->getTagsFiltersWithNumbers( $currDateTime, $arrayArgs['date-start'][0], 
			$arrayArgs['date-end'][0], $chefsCondition, $arrayArgs['location'][0] );
		
		//$selectedTiffins= ATiffin::model()->findAll( array(
        //			'condition'=>'id < 100', 'order'=>'id DESC',));
					
		if( Yii::app()->getRequest()->getIsAjaxRequest() and $_GET['ajax'] == 1)
		{
			Yii::app()->getClientScript()->enableRenderingForAjaxResponse = true;
			//datetimepicker js and css should be stopped from loading again.As intitial page load of
			//tiffin/index does it.
			$assetUrl1 = Yii::app()->assetManager->publish(Yii::getPathOfAlias('ext.YiiDateTimePicker.assets'));
			Yii::app()->getClientScript()->bannedCoreScripts[] = 'jquery';
        	Yii::app()->getClientScript()->bannedJsFiles[] = $assetUrl1 . '/jquery.datetimepicker.js';
        	Yii::app()->getClientScript()->bannedCssFiles[] = $assetUrl1 . '/jquery.datetimepicker.css';
			$html_code	=	$this->renderPartial('results_grid', array(
				'selectedTiffins'=>$selectedTiffins,
				'chefsfiltersArr'=>$chefsfiltersArr,
				'tagsfiltersArr'=>$tagsfiltersArr,
				'arrayArgs'=>$arrayArgs,
				'locality_arr'=>$locality_arr,
			), true, true);
			$ajaxResponse = Yii::app()->getClientScript()->returnScriptStore();
			$ajaxResponse[ "html_code" ] = $html_code;
			Yii::app()->getClientScript()->bannedCoreScripts = array();
			Yii::app()->getClientScript()->bannedJsFiles = array();
			Yii::app()->getClientScript()->bannedCssFiles = array();
			Yii::app()->getClientScript()->enableRenderingForAjaxResponse = false;
			echo CJSON::encode( $ajaxResponse );
			return;
		}
		
		$this->render('index',array(
			'selectedTiffins'=>$selectedTiffins,
			'chefsfiltersArr'=>$chefsfiltersArr,
			'tagsfiltersArr'=>$tagsfiltersArr,
			'arrayArgs'=>$arrayArgs,
			'locality_arr'=>$locality_arr,
		)
		);
	}

	public function getTagsFiltersWithNumbers( $currDateTime, $deliveryDateStart, $deliveryDateStop,
		$chefsCondition, $locality )
	{
		$sql = "";
		if( $chefsCondition != '')
		{
			$chefsCondition = ' AND '.$chefsCondition.' ';
		}
		$sql = $sql.'SELECT  aFoodTagsAll.tag_name AS name ,
			 ( CASE WHEN t.id is null THEN 0 ELSE count(*) END) AS num   
			 FROM `a_tiffin` `t` 
			 INNER JOIN `a_user_details` `tiffin2userDetails` 
			 ON (`t`.`tiffin2user_details`=`tiffin2userDetails`.`id`) 
			 AND (tiffin2userDetails.is_active=1 AND tiffin2userDetails.user_type = 1) 
			 AND (t.verified_by != "not verified" AND t.is_deleted = "no") 
			 '.$chefsCondition.'  
			 INNER JOIN `aa_user_details2bangalore_localities` `aBangaloreLocalities_aBangaloreLocalities` 
			 ON (`tiffin2userDetails`.`id`=`aBangaloreLocalities_aBangaloreLocalities`.`id2user_details_id`) 
			 INNER JOIN `a_bangalore_localities` `aBangaloreLocalities` 
			 ON (`aBangaloreLocalities`.`id`=`aBangaloreLocalities_aBangaloreLocalities`.`id2bangalore_localities_id`) 
			 AND (aBangaloreLocalities.locality_name="'.$locality.'") 
			 AND (aBangaloreLocalities.is_deleted = "no" ) 
			 INNER JOIN `a_price_time` `aPriceTimes` 
			 ON (`aPriceTimes`.`price_time2tiffin`=`t`.`id`) 
			 AND (aPriceTimes.order_start_time <= "'.$currDateTime.'" 
			 AND aPriceTimes.order_end_time >= "'.$currDateTime.'" 
			 AND aPriceTimes.order_delivery_time >= "'.$deliveryDateStart.'" 
			 AND aPriceTimes.order_delivery_time <= "'.$deliveryDateStop.'") 
			 AND (aPriceTimes.verified_by != "not verified" AND aPriceTimes.is_deleted = "no")  
			 INNER JOIN `aa_tiffin2food_tags` `aFoodTagsAll_aFoodTagsAll` 
			 ON (`t`.`id`=`aFoodTagsAll_aFoodTagsAll`.`id2tiffin_id`) 
			 RIGHT OUTER JOIN `a_food_tags` `aFoodTagsAll` 
			 ON (`aFoodTagsAll`.`id`=`aFoodTagsAll_aFoodTagsAll`.`id2food_tags_id`) 
			 WHERE (aFoodTagsAll.is_deleted = "no") 
			 GROUP BY  aFoodTagsAll.tag_name 
			 ORDER BY num DESC, 
			 aFoodTagsAll.tag_name ASC;';
		
		return $this->executeSQLQueryAndReturnProcessedResultArray( $sql );
	}

	public function executeSQLQueryAndReturnProcessedResultArray( $sql )
	{
		$list= Yii::app()->db->createCommand( $sql )->queryAll();
		$rs=array();
		foreach($list as $item)
		{
    		//process each item here
    		$rs[ strtolower( $item['name'] ) ]= $item['num'] ;//lower case the alphabets
		}
		return $rs;
	}

	public function getChefsFiltersWithNumbers( $currDateTime, $deliveryDateStart, $deliveryDateStop,
		$tagsCondition, $locality )
	{
		$sql = "";
		if( $tagsCondition != '')
		{
			//extra select added as tiffin row was coming n times if n tags were matching.
			$sql = $sql.'SELECT name, 
				rating, 
				( CASE WHEN tiffinId is null THEN 0 ELSE count(*) END) AS num 
				FROM
				( 
				SELECT DISTINCT tiffin2userDetails.unique_name AS name , 
				tiffin2userDetails.rating_of_tiffinwala AS rating , 
				t.id as tiffinId 
				FROM `a_user_details` `tiffin2userDetails` 
				INNER JOIN `aa_user_details2bangalore_localities` `aBangaloreLocalities_aBangaloreLocalities` 
				ON (`tiffin2userDetails`.`id`=`aBangaloreLocalities_aBangaloreLocalities`.`id2user_details_id`) 
				AND (tiffin2userDetails.is_active=1 AND tiffin2userDetails.user_type = 1) 
				INNER JOIN `a_bangalore_localities` `aBangaloreLocalities` 
				ON (`aBangaloreLocalities`.`id`=`aBangaloreLocalities_aBangaloreLocalities`.`id2bangalore_localities_id`) 
				AND (aBangaloreLocalities.locality_name="'.$locality.'")  
				AND (aBangaloreLocalities.is_deleted = "no" ) 
				LEFT OUTER JOIN( `a_tiffin` `t` 
				INNER JOIN `a_price_time` `aPriceTimes` 
				ON (`aPriceTimes`.`price_time2tiffin`=`t`.`id`) 
				AND (aPriceTimes.order_start_time <= "'.$currDateTime.'" 
				AND aPriceTimes.order_end_time >= "'.$currDateTime.'" 
				AND aPriceTimes.order_delivery_time >= "'.$deliveryDateStart.'" 
				AND aPriceTimes.order_delivery_time <= "'.$deliveryDateStop.'") 
				AND (aPriceTimes.verified_by != "not verified" AND aPriceTimes.is_deleted = "no") 
				AND (t.verified_by != "not verified" AND t.is_deleted = "no") 
				INNER JOIN `aa_tiffin2food_tags` `aFoodTags_aFoodTags` 
				ON (`t`.`id`=`aFoodTags_aFoodTags`.`id2tiffin_id`) 
				INNER JOIN `a_food_tags` `aFoodTags` 
				ON (`aFoodTags`.`id`=`aFoodTags_aFoodTags`.`id2food_tags_id`) 
				AND ('.$tagsCondition.')  
				AND (aFoodTags.is_deleted = "no") 
				) ON (`t`.`tiffin2user_details`=`tiffin2userDetails`.`id`)  
				) AS distinct_table
				GROUP BY name 
				ORDER BY num DESC, rating DESC;';
		}
		else
		{
			$sql = $sql.'SELECT tiffin2userDetails.unique_name AS name , 
				tiffin2userDetails.rating_of_tiffinwala AS rating , 
				( CASE WHEN t.id is null THEN 0 ELSE count(*) END) AS num 
				FROM `a_user_details` `tiffin2userDetails` 
				INNER JOIN `aa_user_details2bangalore_localities` `aBangaloreLocalities_aBangaloreLocalities` 
				ON (`tiffin2userDetails`.`id`=`aBangaloreLocalities_aBangaloreLocalities`.`id2user_details_id`) 
				AND (tiffin2userDetails.is_active=1 AND tiffin2userDetails.user_type = 1) 
				INNER JOIN `a_bangalore_localities` `aBangaloreLocalities` 
				ON (`aBangaloreLocalities`.`id`=`aBangaloreLocalities_aBangaloreLocalities`.`id2bangalore_localities_id`) 
				AND (aBangaloreLocalities.locality_name="'.$locality.'")  
				AND (aBangaloreLocalities.is_deleted = "no" ) 
				LEFT OUTER JOIN( `a_tiffin` `t` 
				INNER JOIN `a_price_time` `aPriceTimes` 
				ON (`aPriceTimes`.`price_time2tiffin`=`t`.`id`) 
				AND (aPriceTimes.order_start_time <= "'.$currDateTime.'" 
				AND aPriceTimes.order_end_time >= "'.$currDateTime.'" 
				AND aPriceTimes.order_delivery_time >= "'.$deliveryDateStart.'" 
				AND aPriceTimes.order_delivery_time <= "'.$deliveryDateStop.'") 
				AND (aPriceTimes.verified_by != "not verified" 
				AND aPriceTimes.is_deleted = "no") 
				AND (t.verified_by != "not verified" AND t.is_deleted = "no")
				) ON (`t`.`tiffin2user_details`=`tiffin2userDetails`.`id`)  
				GROUP BY tiffin2userDetails.unique_name 
				ORDER BY num DESC, tiffin2userDetails.rating_of_tiffinwala DESC;';
			
		}		
		return $this->executeSQLQueryAndReturnProcessedResultArray( $sql );
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new ATiffin('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['ATiffin']))
			$model->attributes=$_GET['ATiffin'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return ATiffin the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id, $condition = '')
	{
		$model=ATiffin::model()->/*with('aPriceTimes','tiffin2userDetails',
				'aFoodTags')->*/findByPk($id, $condition );
		if($model===null)
			throw new CHttpException(404,'Either, the requested page does not exist or you are not allowed to view this page now.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param ATiffin $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='atiffin-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}

}
