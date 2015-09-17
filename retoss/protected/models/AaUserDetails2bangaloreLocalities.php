<?php

/**
 * This is the model class for table "aa_user_details2bangalore_localities".
 *
 * The followings are the available columns in table 'aa_user_details2bangalore_localities':
 * @property string $id2user_details_id
 * @property string $id2bangalore_localities_id
 * @property string $is_deleted
 */
class AaUserDetails2bangaloreLocalities extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'aa_user_details2bangalore_localities';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id2user_details_id, id2bangalore_localities_id', 'length', 'max'=>20),
			array('is_deleted', 'length', 'max'=>45),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id2user_details_id, id2bangalore_localities_id, is_deleted', 'safe', 'on'=>'search'),
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
			'id2user_details_id' => 'Id2user Details',
			'id2bangalore_localities_id' => 'Id2bangalore Localities',
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

		$criteria->compare('id2user_details_id',$this->id2user_details_id,true);
		$criteria->compare('id2bangalore_localities_id',$this->id2bangalore_localities_id,true);
		$criteria->compare('is_deleted',$this->is_deleted,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return AaUserDetails2bangaloreLocalities the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
