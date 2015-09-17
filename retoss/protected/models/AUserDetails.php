<?php

/**
 * This is the model class for table "a_user_details".
 *
 * The followings are the available columns in table 'a_user_details':
 * @property string $id
 * @property integer $is_active
 * @property integer $user_type
 * @property string $first_name
 * @property string $last_name
 * @property string $dob
 * @property string $user_details2time_details
 * @property string $expiry_date_of_tiffinwala
 * @property integer $rating_of_tiffinwala
 * @property string $is_deleted
 * @property string $activkey
 * @property string $sms_email_setting
 * @property string $unique_name
 * @property string $num_of_visits
 * @property string $verified_for_delivery
 * @property string $vendor_type
 * @property string $base_locality2bangalore_locality
 * @property string $bio_or_status
 * @property string $about
 * @property string $image
 *
 * The followings are the available model relations:
 * @property ACart[] $aCarts
 * @property ANotifications[] $aNotifications
 * @property AOrder[] $aOrders
 * @property AOrder[] $aOrders1
 * @property AReview[] $aReviews
 * @property ATiffin[] $aTiffins
 * @property ABangaloreLocalities $baseLocality2bangaloreLocality
 * @property AUserLogin[] $aUserLogins
 * @property AWallet[] $aWallets
 * @property ABangaloreLocalities[] $aBangaloreLocalities
 * @property APhotos[] $aPhotoses
 */
class AUserDetails extends CActiveRecord
{
	const STATUS_NOACTIVE=0;
	const STATUS_ACTIVE=1;
	const STATUS_BANNED=-1;
	
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'a_user_details';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('is_active, user_type, rating_of_tiffinwala', 'numerical', 'integerOnly'=>true),
			array('first_name, last_name, unique_name, vendor_type, image', 'length', 'max'=>45, 'min' => 3,'message' => "Incorrect (length between 3 and 20 characters)."),
			array('user_details2time_details, sms_email_setting, num_of_visits, verified_for_delivery, base_locality2bangalore_locality', 'length', 'max'=>20),
			array('activkey', 'length', 'max'=>128),
			array('bio_or_status', 'length', 'max'=>150),
			array('about', 'length', 'max'=>500),
			array('dob, expiry_date_of_tiffinwala', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, is_active, user_type, first_name, last_name, dob, user_details2time_details, expiry_date_of_tiffinwala, rating_of_tiffinwala, is_deleted, activkey, sms_email_setting, unique_name, num_of_visits, verified_for_delivery, vendor_type, base_locality2bangalore_locality, bio_or_status, about, image', 'safe', 'on'=>'search'),
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
			'aCarts' => array(self::HAS_MANY, 'ACart', 'cart2user'),
			'aNotifications' => array(self::HAS_MANY, 'ANotifications', 'notifications2user_details'),
			'aOrders' => array(self::HAS_MANY, 'AOrder', 'ordered_by2user_details'),
			'aOrders1' => array(self::HAS_MANY, 'AOrder', 'assigned_delivery_boy2user_details'),
			'aReviews' => array(self::HAS_MANY, 'AReview', 'creator2user_details'),
			'aTiffins' => array(self::HAS_MANY, 'ATiffin', 'tiffin2user_details'),
			'baseLocality2bangaloreLocality' => array(self::BELONGS_TO, 'ABangaloreLocalities', 'base_locality2bangalore_locality'),
			'aUserLogins' => array(self::HAS_MANY, 'AUserLogin', 'user_login2user_details', 'joinType'=>'INNER JOIN',),
			'aWallets' => array(self::HAS_MANY, 'AWallet', 'wallet2user_details'),
			'aBangaloreLocalities' => array(self::MANY_MANY, 'ABangaloreLocalities', 'aa_user_details2bangalore_localities(id2user_details_id, id2bangalore_localities_id)', 'joinType'=>'INNER JOIN',),
			'aPhotoses' => array(self::MANY_MANY, 'APhotos', 'aa_user_details2photos(id2user_details_id, id2photos_id)'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'is_active' => 'Is Active',
			'user_type' => 'User Type',
			'first_name' => 'First Name',
			'last_name' => 'Last Name',
			'dob' => 'Dob',
			'user_details2time_details' => 'User Details2time Details',
			'expiry_date_of_tiffinwala' => 'Expiry Date Of Tiffinwala',
			'rating_of_tiffinwala' => 'Rating Of Tiffinwala',
			'is_deleted' => 'Is Deleted',
			'activkey' => 'Activkey',
			'sms_email_setting' => 'Sms Email Setting',
			'unique_name' => 'Unique Name',
			'num_of_visits' => 'Num Of Visits',
			'verified_for_delivery' => 'Verified For Delivery',
			'vendor_type' => 'Vendor Type',
			'base_locality2bangalore_locality' => 'Base Locality2bangalore Locality',
			'bio_or_status' => 'Bio Or Status',
			'about' => 'About',
			'image' => 'Image',
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
		$criteria->compare('is_active',$this->is_active);
		$criteria->compare('user_type',$this->user_type);
		$criteria->compare('first_name',$this->first_name,true);
		$criteria->compare('last_name',$this->last_name,true);
		$criteria->compare('dob',$this->dob,true);
		$criteria->compare('user_details2time_details',$this->user_details2time_details,true);
		$criteria->compare('expiry_date_of_tiffinwala',$this->expiry_date_of_tiffinwala,true);
		$criteria->compare('rating_of_tiffinwala',$this->rating_of_tiffinwala);
		$criteria->compare('is_deleted',$this->is_deleted,true);
		$criteria->compare('activkey',$this->activkey,true);
		$criteria->compare('sms_email_setting',$this->sms_email_setting,true);
		$criteria->compare('unique_name',$this->unique_name,true);
		$criteria->compare('num_of_visits',$this->num_of_visits,true);
		$criteria->compare('verified_for_delivery',$this->verified_for_delivery,true);
		$criteria->compare('vendor_type',$this->vendor_type,true);
		$criteria->compare('base_locality2bangalore_locality',$this->base_locality2bangalore_locality,true);
		$criteria->compare('bio_or_status',$this->bio_or_status,true);
		$criteria->compare('about',$this->about,true);
		$criteria->compare('image',$this->image,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return AUserDetails the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
