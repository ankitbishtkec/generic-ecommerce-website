<?php

/**
 * This is the model class for table "a_bangalore_localities".
 *
 * The followings are the available columns in table 'a_bangalore_localities':
 * @property string $id
 * @property string $locality_name
 * @property string $is_deleted
 * @property string $locality_abbreviation_ten_chars
 *
 * The followings are the available model relations:
 * @property AAddress[] $aAddresses
 * @property AUserDetails[] $aUserDetails
 * @property AUserDetails[] $aUserDetails1
 */
class ABangaloreLocalities extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'a_bangalore_localities';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('locality_name, is_deleted, locality_abbreviation_ten_chars', 'length', 'max'=>45),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, locality_name, is_deleted, locality_abbreviation_ten_chars', 'safe', 'on'=>'search'),
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
			'aAddresses' => array(self::HAS_MANY, 'AAddress', 'address2bangalore_localities'),
			'aUserDetails' => array(self::HAS_MANY, 'AUserDetails', 'base_locality2bangalore_locality'),
			'aUserDetails1' => array(self::MANY_MANY, 'AUserDetails', 'aa_user_details2bangalore_localities(id2bangalore_localities_id, id2user_details_id)'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'locality_name' => 'Locality Name',
			'is_deleted' => 'Is Deleted',
			'locality_abbreviation_ten_chars' => 'Locality Abbreviation Ten Chars',
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
		$criteria->compare('locality_name',$this->locality_name,true);
		$criteria->compare('is_deleted',$this->is_deleted,true);
		$criteria->compare('locality_abbreviation_ten_chars',$this->locality_abbreviation_ten_chars,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return ABangaloreLocalities the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
