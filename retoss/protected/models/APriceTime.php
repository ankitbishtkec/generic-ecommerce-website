<?php

/**
 * This is the model class for table "a_price_time".
 *
 * The followings are the available columns in table 'a_price_time':
 * @property string $id
 * @property string $price_after_discount
 * @property string $vendor_price_after_discount
 * @property string $discount
 * @property string $vendor_discount
 * @property string $margin
 * @property string $price_time2tiffin
 * @property string $is_deleted
 * @property string $order_start_time
 * @property string $order_end_time
 * @property string $order_pickup_time
 * @property string $order_delivery_time
 * @property string $verified_by
 * @property string $initial_quantity
 * @property string $quantity_currently_available
 * @property string $num_of_orders
 * @property integer $orderType
 *
 * The followings are the available model relations:
 * @property AOrder[] $aOrders
 * @property ATiffin $priceTime2tiffin
 */
class APriceTime extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'a_price_time';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('orderType', 'numerical', 'integerOnly'=>true),
			array('price_after_discount, vendor_price_after_discount, margin, price_time2tiffin, initial_quantity, quantity_currently_available, num_of_orders', 'length', 'max'=>20),
			array('discount, vendor_discount', 'length', 'max'=>10),
			array('is_deleted, verified_by', 'length', 'max'=>45),
			array('order_start_time, order_end_time, order_pickup_time, order_delivery_time', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, price_after_discount, vendor_price_after_discount, discount, vendor_discount, margin, price_time2tiffin, is_deleted, order_start_time, order_end_time, order_pickup_time, order_delivery_time, verified_by, initial_quantity, quantity_currently_available, num_of_orders, orderType', 'safe', 'on'=>'search'),
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
			'aOrders' => array(self::HAS_MANY, 'AOrder', 'order2price_time'),
			'priceTime2tiffin' => array(self::BELONGS_TO, 'ATiffin', 'price_time2tiffin'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'price_after_discount' => 'Price After Discount',
			'vendor_price_after_discount' => 'Vendor Price After Discount',
			'discount' => 'Discount',
			'vendor_discount' => 'Vendor Discount',
			'margin' => 'Margin',
			'price_time2tiffin' => 'Price Time2tiffin',
			'is_deleted' => 'Is Deleted',
			'order_start_time' => 'Order Start Time',
			'order_end_time' => 'Order End Time',
			'order_pickup_time' => 'Order Pickup Time',
			'order_delivery_time' => 'Order Delivery Time',
			'verified_by' => 'Verified By',
			'initial_quantity' => 'Initial Quantity',
			'quantity_currently_available' => 'Quantity Currently Available',
			'num_of_orders' => 'Num Of Orders',
			'orderType' => 'Order Type',
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
		$criteria->compare('price_after_discount',$this->price_after_discount,true);
		$criteria->compare('vendor_price_after_discount',$this->vendor_price_after_discount,true);
		$criteria->compare('discount',$this->discount,true);
		$criteria->compare('vendor_discount',$this->vendor_discount,true);
		$criteria->compare('margin',$this->margin,true);
		$criteria->compare('price_time2tiffin',$this->price_time2tiffin,true);
		$criteria->compare('is_deleted',$this->is_deleted,true);
		$criteria->compare('order_start_time',$this->order_start_time,true);
		$criteria->compare('order_end_time',$this->order_end_time,true);
		$criteria->compare('order_pickup_time',$this->order_pickup_time,true);
		$criteria->compare('order_delivery_time',$this->order_delivery_time,true);
		$criteria->compare('verified_by',$this->verified_by,true);
		$criteria->compare('initial_quantity',$this->initial_quantity,true);
		$criteria->compare('quantity_currently_available',$this->quantity_currently_available,true);
		$criteria->compare('num_of_orders',$this->num_of_orders,true);
		$criteria->compare('orderType',$this->orderType);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return APriceTime the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
