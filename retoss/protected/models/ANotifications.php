<?php

/**
 * This is the model class for table "a_notifications".
 *
 * The followings are the available columns in table 'a_notifications':
 * @property string $id
 * @property string $event_description
 * @property string $link
 * @property integer $is_read
 * @property string $notifications2user_details
 * @property string $notifications2time_details
 * @property string $is_deleted
 *
 * The followings are the available model relations:
 * @property AUserDetails $notifications2userDetails
 * @property TimeDetails $notifications2timeDetails
 */
class ANotifications extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'a_notifications';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('is_read', 'numerical', 'integerOnly'=>true),
			array('id, notifications2user_details, notifications2time_details', 'length', 'max'=>20),
			array('event_description, link', 'length', 'max'=>100),
			array('is_deleted', 'length', 'max'=>45),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, event_description, link, is_read, notifications2user_details, notifications2time_details, is_deleted', 'safe', 'on'=>'search'),
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
			'notifications2userDetails' => array(self::BELONGS_TO, 'AUserDetails', 'notifications2user_details'),
			'notifications2timeDetails' => array(self::BELONGS_TO, 'TimeDetails', 'notifications2time_details'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'event_description' => 'Event Description',
			'link' => 'Link',
			'is_read' => 'Is Read',
			'notifications2user_details' => 'Notifications2user Details',
			'notifications2time_details' => 'Notifications2time Details',
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
		$criteria->compare('event_description',$this->event_description,true);
		$criteria->compare('link',$this->link,true);
		$criteria->compare('is_read',$this->is_read);
		$criteria->compare('notifications2user_details',$this->notifications2user_details,true);
		$criteria->compare('notifications2time_details',$this->notifications2time_details,true);
		$criteria->compare('is_deleted',$this->is_deleted,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return ANotifications the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
