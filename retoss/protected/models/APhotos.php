<?php

/**
 * This is the model class for table "a_photos".
 *
 * The followings are the available columns in table 'a_photos':
 * @property string $id
 * @property string $photo_path
 * @property string $is_deleted
 * @property string $meta_data
 * @property string $meta_data_1
 * @property string $type
 * @property string $height
 * @property string $width
 *
 * The followings are the available model relations:
 * @property ATiffin[] $aTiffins
 * @property AUserDetails[] $aUserDetails
 */
class APhotos extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'a_photos';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('photo_path', 'length', 'max'=>200),
			array('is_deleted, meta_data, meta_data_1, type', 'length', 'max'=>45),
			array('height, width', 'length', 'max'=>20),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, photo_path, is_deleted, meta_data, meta_data_1, type, height, width', 'safe', 'on'=>'search'),
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
			'aTiffins' => array(self::MANY_MANY, 'ATiffin', 'aa_tiffin2photos(id2photos_id, id2tiffin_id)'),
			'aUserDetails' => array(self::MANY_MANY, 'AUserDetails', 'aa_user_details2photos(id2photos_id, id2user_details_id)'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'photo_path' => 'Photo Path',
			'is_deleted' => 'Is Deleted',
			'meta_data' => 'Meta Data',
			'meta_data_1' => 'Meta Data 1',
			'type' => 'Type',
			'height' => 'Height',
			'width' => 'Width',
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
		$criteria->compare('photo_path',$this->photo_path,true);
		$criteria->compare('is_deleted',$this->is_deleted,true);
		$criteria->compare('meta_data',$this->meta_data,true);
		$criteria->compare('meta_data_1',$this->meta_data_1,true);
		$criteria->compare('type',$this->type,true);
		$criteria->compare('height',$this->height,true);
		$criteria->compare('width',$this->width,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return APhotos the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
