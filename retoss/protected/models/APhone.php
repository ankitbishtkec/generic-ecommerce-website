<?php

/**
 * This is the model class for table "a_phone".
 *
 * The followings are the available columns in table 'a_phone':
 * @property string $id
 * @property string $country_code
 * @property integer $area_code
 * @property string $phone_num
 * @property string $phone2time_details
 * @property string $is_deleted
 * @property string $meta_data
 * @property string $a_meta_data_1
 * @property string $link
 * @property string $link_table
 */
class APhone extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'a_phone';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('area_code', 'numerical', 'integerOnly'=>true),
			array('country_code', 'length', 'max'=>10),
			array('phone_num, phone2time_details, link', 'length', 'max'=>20),
			array('is_deleted, meta_data, a_meta_data_1, link_table', 'length', 'max'=>45),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, country_code, area_code, phone_num, phone2time_details, is_deleted, meta_data, a_meta_data_1, link, link_table', 'safe', 'on'=>'search'),
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
			'country_code' => 'Country Code',
			'area_code' => 'Area Code',
			'phone_num' => 'Phone Num',
			'phone2time_details' => 'Phone2time Details',
			'is_deleted' => 'Is Deleted',
			'meta_data' => 'Meta Data',
			'a_meta_data_1' => 'A Meta Data 1',
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
		$criteria->compare('country_code',$this->country_code,true);
		$criteria->compare('area_code',$this->area_code);
		$criteria->compare('phone_num',$this->phone_num,true);
		$criteria->compare('phone2time_details',$this->phone2time_details,true);
		$criteria->compare('is_deleted',$this->is_deleted,true);
		$criteria->compare('meta_data',$this->meta_data,true);
		$criteria->compare('a_meta_data_1',$this->a_meta_data_1,true);
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
	 * @return APhone the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
