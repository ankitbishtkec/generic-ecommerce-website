<?php

/**
 * This is the model class for table "time_details".
 *
 * The followings are the available columns in table 'time_details':
 * @property string $id
 * @property string $created_datetime
 * @property string $last_updated_datetime
 * @property string $last_used_datetime
 * @property string $is_deleted
 *
 * The followings are the available model relations:
 * @property ANotifications[] $aNotifications
 * @property AReview[] $aReviews
 * @property AaWalletHistory[] $aaWalletHistories
 */
class TimeDetails extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'time_details';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('is_deleted', 'length', 'max'=>45),
			array('created_datetime, last_updated_datetime, last_used_datetime', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, created_datetime, last_updated_datetime, last_used_datetime, is_deleted', 'safe', 'on'=>'search'),
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
			'aNotifications' => array(self::HAS_MANY, 'ANotifications', 'notifications2time_details'),
			'aReviews' => array(self::HAS_MANY, 'AReview', 'review2time_details'),
			'aaWalletHistories' => array(self::HAS_MANY, 'AaWalletHistory', 'wallet_history2time_details'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'created_datetime' => 'Created Datetime',
			'last_updated_datetime' => 'Last Updated Datetime',
			'last_used_datetime' => 'Last Used Datetime',
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
		$criteria->compare('created_datetime',$this->created_datetime,true);
		$criteria->compare('last_updated_datetime',$this->last_updated_datetime,true);
		$criteria->compare('last_used_datetime',$this->last_used_datetime,true);
		$criteria->compare('is_deleted',$this->is_deleted,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return TimeDetails the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
