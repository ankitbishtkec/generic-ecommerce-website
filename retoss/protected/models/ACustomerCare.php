<?php

/**
 * This is the model class for table "a_customer_care".
 *
 * The followings are the available columns in table 'a_customer_care':
 * @property string $id
 * @property string $request_by_user
 * @property string $action_taken
 * @property string $issue2order
 * @property string $is_deleted
 *
 * The followings are the available model relations:
 * @property AOrder $issue2order0
 */
class ACustomerCare extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'a_customer_care';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('request_by_user, action_taken', 'length', 'max'=>200),
			array('issue2order', 'length', 'max'=>20),
			array('is_deleted', 'length', 'max'=>45),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, request_by_user, action_taken, issue2order, is_deleted', 'safe', 'on'=>'search'),
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
			'issue2order0' => array(self::BELONGS_TO, 'AOrder', 'issue2order'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'request_by_user' => 'Request By User',
			'action_taken' => 'Action Taken',
			'issue2order' => 'Issue2order',
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
		$criteria->compare('request_by_user',$this->request_by_user,true);
		$criteria->compare('action_taken',$this->action_taken,true);
		$criteria->compare('issue2order',$this->issue2order,true);
		$criteria->compare('is_deleted',$this->is_deleted,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return ACustomerCare the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
