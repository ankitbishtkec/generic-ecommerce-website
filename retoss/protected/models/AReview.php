<?php

/**
 * This is the model class for table "a_review".
 *
 * The followings are the available columns in table 'a_review':
 * @property string $id
 * @property integer $quality
 * @property integer $taste
 * @property integer $quantity
 * @property integer $value_for_money
 * @property integer $hygiene
 * @property integer $packing
 * @property integer $delivery_process
 * @property integer $customer_satisfaction
 * @property string $remarks
 * @property string $review2time_details
 * @property string $creator2user_details
 * @property string $reviewed2tiffin
 * @property string $is_deleted
 *
 * The followings are the available model relations:
 * @property AUserDetails $creator2userDetails
 * @property TimeDetails $review2timeDetails
 * @property ATiffin $reviewed2tiffin0
 */
class AReview extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'a_review';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('quality, taste, quantity, value_for_money, hygiene, packing, delivery_process, customer_satisfaction', 'numerical', 'integerOnly'=>true),
			array('remarks', 'length', 'max'=>300),
			array('review2time_details, creator2user_details, reviewed2tiffin', 'length', 'max'=>20),
			array('is_deleted', 'length', 'max'=>45),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, quality, taste, quantity, value_for_money, hygiene, packing, delivery_process, customer_satisfaction, remarks, review2time_details, creator2user_details, reviewed2tiffin, is_deleted', 'safe', 'on'=>'search'),
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
			'creator2userDetails' => array(self::BELONGS_TO, 'AUserDetails', 'creator2user_details'),
			'review2timeDetails' => array(self::BELONGS_TO, 'TimeDetails', 'review2time_details'),
			'reviewed2tiffin0' => array(self::BELONGS_TO, 'ATiffin', 'reviewed2tiffin'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'quality' => 'Quality',
			'taste' => 'Taste',
			'quantity' => 'Quantity',
			'value_for_money' => 'Value For Money',
			'hygiene' => 'Hygiene',
			'packing' => 'Packing',
			'delivery_process' => 'Delivery Process',
			'customer_satisfaction' => 'Customer Satisfaction',
			'remarks' => 'Remarks',
			'review2time_details' => 'Review2time Details',
			'creator2user_details' => 'Creator2user Details',
			'reviewed2tiffin' => 'Reviewed2tiffin',
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
		$criteria->compare('quality',$this->quality);
		$criteria->compare('taste',$this->taste);
		$criteria->compare('quantity',$this->quantity);
		$criteria->compare('value_for_money',$this->value_for_money);
		$criteria->compare('hygiene',$this->hygiene);
		$criteria->compare('packing',$this->packing);
		$criteria->compare('delivery_process',$this->delivery_process);
		$criteria->compare('customer_satisfaction',$this->customer_satisfaction);
		$criteria->compare('remarks',$this->remarks,true);
		$criteria->compare('review2time_details',$this->review2time_details,true);
		$criteria->compare('creator2user_details',$this->creator2user_details,true);
		$criteria->compare('reviewed2tiffin',$this->reviewed2tiffin,true);
		$criteria->compare('is_deleted',$this->is_deleted,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return AReview the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
