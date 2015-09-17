<?php

/**
 * This is the model class for table "a_cart".
 *
 * The followings are the available columns in table 'a_cart':
 * @property string $id
 * @property string $added_time
 * @property string $cart2tiffin
 * @property string $cart2user
 * @property string $quantity
 * @property string $status
 * @property string $meta_data
 * @property string $is_deleted
 *
 * The followings are the available model relations:
 * @property ATiffin $cart2tiffin0
 * @property AUserDetails $cart2user0
 */
class ACart extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'a_cart';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id, cart2tiffin, cart2user, quantity', 'length', 'max'=>20),
			array('status, meta_data, is_deleted', 'length', 'max'=>45),
			array('added_time', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, added_time, cart2tiffin, cart2user, quantity, status, meta_data, is_deleted', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'cart2tiffin0' => array(self::BELONGS_TO, 'ATiffin', 'cart2tiffin'),
			'cart2user0' => array(self::BELONGS_TO, 'AUserDetails', 'cart2user'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'added_time' => 'Added Time',
			'cart2tiffin' => 'Cart2tiffin',
			'cart2user' => 'Cart2user',
			'quantity' => 'Quantity',
			'status' => 'Status',
			'meta_data' => 'Meta Data',
			'is_deleted' => 'Is Deleted',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 *
	 * Typical usecase:
	 * - Initialize the model fields with values from filter form.
	 * - Execute this method to get CActiveDataProvider instance which will filter
	 * models according to data in model fields.
	 * - Pass data provider to CGridView, CListView or any similar widget.
	 *
	 * @return CActiveDataProvider the data provider that can return the models
	 * based on the search/filter conditions.
	 */
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id,true);
		$criteria->compare('added_time',$this->added_time,true);
		$criteria->compare('cart2tiffin',$this->cart2tiffin,true);
		$criteria->compare('cart2user',$this->cart2user,true);
		$criteria->compare('quantity',$this->quantity,true);
		$criteria->compare('status',$this->status,true);
		$criteria->compare('meta_data',$this->meta_data,true);
		$criteria->compare('is_deleted',$this->is_deleted,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	
	/**
	 * gets cart values
	 * $location to select tiffins at a particular location
	 * $doeditcart edit cart if needed.
	 * return
	 */
	public static function getCart( $location = null, $doeditcart = 1 )
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
		//if( Yii::app()->getRequest()->getIsAjaxRequest() and $_GET['ajax'] == 1 )
		{
			if( Yii::app()->user->isGuest )//saved in cookie
			{
				$cartCookiesArr = array();
				$allCookies = Yii::app()->request->getCookies();
				if( isset( $allCookies[ Yii::app()->params['cartCookieName'] ] ) )
					$cartCookiesArr = CJSON::decode( $allCookies[ Yii::app()->params['cartCookieName'] ]->value
						, true );
				$cartArr = array();
				if( isset( $cartCookiesArr ) )
					foreach( $cartCookiesArr as $key=>$value)
					{
						$cartArr[ $key ] = $value[ 0 ];//array(tiffinid=>quantity,...)
					}	
				$cartData = AppCommon::modifyInputTiffinsQuantity( $cartArr, $location );
				
				if( $cartData[ "has_changed" ] )//is true
				{
					if( isset( $cartCookiesArr ) )
					foreach( $cartCookiesArr as $key1=>$value1)
					{
						if( isset( $cartData[ $key1 ] ) and ( $cartData[ $key1 ][ "has_changed" ] ) )//is true
						{
							if( ( $cartData[ $key1 ][ "error_msg" ] == AppCommon::$cartErrorMsgTiffinNotExist ) )
							//remove such tiffin even if $doEditCart is false 
							{
								unset( $cartCookiesArr[ $key1 ] );
							}
							else if( $cartData[ $key1 ][ "error_msg" ] == AppCommon::$cartErrorMsgTiffinNotAvailable and
							$doeditcart == 1 )
							{
								unset( $cartCookiesArr[ $key1 ] );
							}
							else if( $cartData[ $key1 ][ "error_msg" ] == AppCommon::$cartErrorMsgTiffinQuanCappedToLimits and
							$doeditcart == 1 )
							{
								$cartCookiesArr[ $key1 ][ 0 ] = $cartData[ $key1 ][ "quantity" ];
							}
						}
					}					
				//update the cookie
				//TODO:: check CJSON::encode( $cartCookiesArr ) is not null
				$allCookies[ Yii::app()->params['cartCookieName'] ] = 
					new CHttpCookie( Yii::app()->params['cartCookieName'], CJSON::encode( $cartCookiesArr ), 
					array(
						'expire'=> time()+60*60*24*100,//in seconds 100 days
						'httpOnly'=>true,
					));
				}
			}
			else //saved in db
			{	
				$alreadyPresentRecord = ACart::model()->findAll( array(
        			'condition'=>'is_deleted = "no" AND cart2user = '.AppCommon::getUserDetailsId(),
    				) 
				);
				$cartArr = array();
				foreach( $alreadyPresentRecord as $rec)
				{
					$cartArr[ $rec->cart2tiffin ] = $rec->quantity;//array(tiffinid=>quantity,...)
				}	
				$cartData = AppCommon::modifyInputTiffinsQuantity( $cartArr, $location );	
				
				try
				{
				if( $cartData[ "has_changed" ] )//is true
				{
					foreach( $alreadyPresentRecord as $rec1)
					{
						if( isset( $cartData[ $rec1->cart2tiffin ] ) and ( $cartData[ $rec1->cart2tiffin ][ "has_changed" ] ) )//is true
						{
							if( ( $cartData[ $rec1->cart2tiffin ][ "error_msg" ] == AppCommon::$cartErrorMsgTiffinNotExist ) )
							//remove such tiffin even if $doEditCart is false
							{
								$rec1->is_deleted = AppCommon::getUserDetailsId();
								$rec1->save();//update the record
							}
							else if( $cartData[ $rec1->cart2tiffin ][ "error_msg" ] == AppCommon::$cartErrorMsgTiffinNotAvailable and
							$doeditcart == 1 )
							{
								$rec1->is_deleted = AppCommon::getUserDetailsId();
								$rec1->save();//update the record
							}
							else if( $cartData[ $rec1->cart2tiffin ][ "error_msg" ] == AppCommon::$cartErrorMsgTiffinQuanCappedToLimits and
							$doeditcart == 1 )
							{
								$rec1->quantity = $cartData[ $rec1->cart2tiffin ][ "quantity" ];
								$rec1->save();//update the record
							}
						}
					}
				}
				}
				catch( Exception $e )
				{
					Yii::ankFileSave(" get cart exception while saving cart in db");//added to ignore exception
				}
			}	
		}
		$cartData["total_items"] = AppCommon::cartItemCount( );
		
		return $cartData;	
	}
	

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return ACart the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
