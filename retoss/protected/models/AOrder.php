<?php

/**
 * This is the model class for table "a_order".
 *
 * The followings are the available columns in table 'a_order':
 * @property string $id
 * @property string $order_unique_id
 * @property string $remarks_from_orderer
 * @property string $payment_mode
 * @property string $total_price
 * @property string $per_unit_price
 * @property string $num_of_units
 * @property string $ordered_by2user_details
 * @property string $order2price_time
 * @property string $order2tiffin
 * @property string $order2address
 * @property string $assigned_delivery_boy2user_details
 * @property string $applied_offer_id
 * @property string $applied_order_amount
 * @property string $is_deleted
 * @property string $verification_code
 * @property string $order_pickup_time
 * @property string $order_delivery_time
 * @property string $status
 * @property string $last_status_update
 * @property string $source_phone
 * @property string $destination_phone
 * @property string $source_address
 * @property string $destination_address
 * @property string $source_locality
 * @property string $destination_locality
 * @property string $rejected_by_delivery_boys_comma_seperated_ids
 * @property integer $num_of_rejections_by_delivery_boys
 * @property integer $orderType
 * @property string $wallet_amount_used
 *
 * The followings are the available model relations:
 * @property ACustomerCare[] $aCustomerCares
 * @property AUserDetails $assignedDeliveryBoy2userDetails
 * @property AAddress $order2address0
 * @property APriceTime $order2priceTime
 * @property ATiffin $order2tiffin0
 * @property AUserDetails $orderedBy2userDetails
 * @property AaOrderHistory[] $aaOrderHistories
 */
class AOrder extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'a_order';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('num_of_rejections_by_delivery_boys, orderType', 'numerical', 'integerOnly'=>true),
			array('order_unique_id', 'length', 'max'=>400),
			array('remarks_from_orderer', 'length', 'max'=>100),
			array('payment_mode, is_deleted, verification_code, source_phone, destination_phone', 'length', 'max'=>45),
			array('total_price, per_unit_price, num_of_units, ordered_by2user_details, order2price_time, order2tiffin, order2address, assigned_delivery_boy2user_details, applied_order_amount, wallet_amount_used', 'length', 'max'=>20),
			array('applied_offer_id, source_locality, destination_locality', 'length', 'max'=>50),
			array('status, source_address, destination_address, rejected_by_delivery_boys_comma_seperated_ids', 'length', 'max'=>200),
			array('order_pickup_time, order_delivery_time, last_status_update', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, order_unique_id, remarks_from_orderer, payment_mode, total_price, per_unit_price, num_of_units, ordered_by2user_details, order2price_time, order2tiffin, order2address, assigned_delivery_boy2user_details, applied_offer_id, applied_order_amount, is_deleted, verification_code, order_pickup_time, order_delivery_time, status, last_status_update, source_phone, destination_phone, source_address, destination_address, source_locality, destination_locality, rejected_by_delivery_boys_comma_seperated_ids, num_of_rejections_by_delivery_boys, orderType, wallet_amount_used', 'safe', 'on'=>'search'),
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
			'aCustomerCares' => array(self::HAS_MANY, 'ACustomerCare', 'issue2order'),
			'assignedDeliveryBoy2userDetails' => array(self::BELONGS_TO, 'AUserDetails', 'assigned_delivery_boy2user_details'),
			'order2address0' => array(self::BELONGS_TO, 'AAddress', 'order2address'),
			'order2priceTime' => array(self::BELONGS_TO, 'APriceTime', 'order2price_time'),
			'order2tiffin0' => array(self::BELONGS_TO, 'ATiffin', 'order2tiffin'),
			'orderedBy2userDetails' => array(self::BELONGS_TO, 'AUserDetails', 'ordered_by2user_details'),
			'aaOrderHistories' => array(self::HAS_MANY, 'AaOrderHistory', 'order_history2order'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'order_unique_id' => 'Order Unique',
			'remarks_from_orderer' => 'Remarks From Orderer',
			'payment_mode' => 'Payment Mode',
			'total_price' => 'Total Price',
			'per_unit_price' => 'Per Unit Price',
			'num_of_units' => 'Num Of Units',
			'ordered_by2user_details' => 'Ordered By2user Details',
			'order2price_time' => 'Order2price Time',
			'order2tiffin' => 'Order2tiffin',
			'order2address' => 'Order2address',
			'assigned_delivery_boy2user_details' => 'Assigned Delivery Boy2user Details',
			'applied_offer_id' => 'Applied Offer',
			'applied_order_amount' => 'Applied Order Amount',
			'is_deleted' => 'Is Deleted',
			'verification_code' => 'Verification Code',
			'order_pickup_time' => 'Order Pickup Time',
			'order_delivery_time' => 'Order Delivery Time',
			'status' => 'Status',
			'last_status_update' => 'Last Status Update',
			'source_phone' => 'Source Phone',
			'destination_phone' => 'Destination Phone',
			'source_address' => 'Source Address',
			'destination_address' => 'Destination Address',
			'source_locality' => 'Source Locality',
			'destination_locality' => 'Destination Locality',
			'rejected_by_delivery_boys_comma_seperated_ids' => 'Rejected By Delivery Boys Comma Seperated Ids',
			'num_of_rejections_by_delivery_boys' => 'Num Of Rejections By Delivery Boys',
			'orderType' => 'Order Type',
			'wallet_amount_used' => 'Wallet Amount Used',
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
		$criteria->compare('order_unique_id',$this->order_unique_id,true);
		$criteria->compare('remarks_from_orderer',$this->remarks_from_orderer,true);
		$criteria->compare('payment_mode',$this->payment_mode,true);
		$criteria->compare('total_price',$this->total_price,true);
		$criteria->compare('per_unit_price',$this->per_unit_price,true);
		$criteria->compare('num_of_units',$this->num_of_units,true);
		$criteria->compare('ordered_by2user_details',$this->ordered_by2user_details,true);
		$criteria->compare('order2price_time',$this->order2price_time,true);
		$criteria->compare('order2tiffin',$this->order2tiffin,true);
		$criteria->compare('order2address',$this->order2address,true);
		$criteria->compare('assigned_delivery_boy2user_details',$this->assigned_delivery_boy2user_details,true);
		$criteria->compare('applied_offer_id',$this->applied_offer_id,true);
		$criteria->compare('applied_order_amount',$this->applied_order_amount,true);
		$criteria->compare('is_deleted',$this->is_deleted,true);
		$criteria->compare('verification_code',$this->verification_code,true);
		$criteria->compare('order_pickup_time',$this->order_pickup_time,true);
		$criteria->compare('order_delivery_time',$this->order_delivery_time,true);
		$criteria->compare('status',$this->status,true);
		$criteria->compare('last_status_update',$this->last_status_update,true);
		$criteria->compare('source_phone',$this->source_phone,true);
		$criteria->compare('destination_phone',$this->destination_phone,true);
		$criteria->compare('source_address',$this->source_address,true);
		$criteria->compare('destination_address',$this->destination_address,true);
		$criteria->compare('source_locality',$this->source_locality,true);
		$criteria->compare('destination_locality',$this->destination_locality,true);
		$criteria->compare('rejected_by_delivery_boys_comma_seperated_ids',$this->rejected_by_delivery_boys_comma_seperated_ids,true);
		$criteria->compare('num_of_rejections_by_delivery_boys',$this->num_of_rejections_by_delivery_boys);
		$criteria->compare('orderType',$this->orderType);
		$criteria->compare('wallet_amount_used',$this->wallet_amount_used,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return AOrder the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
