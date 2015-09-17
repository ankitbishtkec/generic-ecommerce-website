<?php

/**
 * This is the model class for table "a_email".
 *
 * The followings are the available columns in table 'a_email':
 * @property string $id
 * @property string $email
 * @property string $email2time_details
 * @property string $is_deleted
 * @property string $meta_data
 * @property string $link
 * @property string $link_table
 */
class AEmail extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'a_email';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('email', 'length', 'max'=>80),
			array('email2time_details, link', 'length', 'max'=>20),
			array('is_deleted, meta_data, link_table', 'length', 'max'=>45),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, email, email2time_details, is_deleted, meta_data, link, link_table', 'safe', 'on'=>'search'),
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
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'email' => 'Email',
			'email2time_details' => 'Email2time Details',
			'is_deleted' => 'Is Deleted',
			'meta_data' => 'Meta Data',
			'link' => 'Link',
			'link_table' => 'Link Table',
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
		$criteria->compare('email',$this->email,true);
		$criteria->compare('email2time_details',$this->email2time_details,true);
		$criteria->compare('is_deleted',$this->is_deleted,true);
		$criteria->compare('meta_data',$this->meta_data,true);
		$criteria->compare('link',$this->link,true);
		$criteria->compare('link_table',$this->link_table,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return AEmail the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
