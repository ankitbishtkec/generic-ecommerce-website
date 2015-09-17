<?php

/**
 * This is the model class for table "a_tiffin".
 *
 * The followings are the available columns in table 'a_tiffin':
 * @property string $id
 * @property string $name
 * @property string $contents
 * @property string $nutrition
 * @property string $verified_by
 * @property double $ranking_index
 * @property string $tiffin2user_details
 * @property string $is_deleted
 * @property string $num_of_orders
 * @property string $num_of_reviews
 * @property double $rating_of_tiffin
 * @property string $image
 * @property string $ingredient_class
 *
 * The followings are the available model relations:
 * @property ACart[] $aCarts
 * @property AOrder[] $aOrders
 * @property APriceTime[] $aPriceTimes
 * @property AReview[] $aReviews
 * @property AUserDetails $tiffin2userDetails
 * @property AFoodTags[] $aFoodTags
 * @property APhotos[] $aPhotoses
 */
class ATiffin extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'a_tiffin';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name, contents, verified_by', 'required'),
			//array('ranking_index, rating_of_tiffin', 'numerical', 'integerOnly'=>true),
			array('ranking_index, rating_of_tiffin', 'numerical',),
			array('name, verified_by, is_deleted, image, ingredient_class', 'length', 'max'=>45),
			array('contents, nutrition', 'length', 'max'=>350),
			array('tiffin2user_details, num_of_orders, num_of_reviews', 'length', 'max'=>20),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, name, contents, nutrition, verified_by, ranking_index, tiffin2user_details, is_deleted, num_of_orders, num_of_reviews, rating_of_tiffin', 'safe', 'on'=>'search'),
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
			'aCarts' => array(self::HAS_MANY, 'ACart', 'cart2tiffin'),
			'aOrders' => array(self::HAS_MANY, 'AOrder', 'order2tiffin'),
			'aPriceTimes' => array(self::HAS_MANY, 'APriceTime', 'price_time2tiffin','joinType'=>'INNER JOIN',),
			'aReviews' => array(self::HAS_MANY, 'AReview', 'reviewed2tiffin'),
			'tiffin2userDetails' => array(self::BELONGS_TO, 'AUserDetails', 'tiffin2user_details','joinType'=>'INNER JOIN',),
			'aFoodTags' => array(self::MANY_MANY, 'AFoodTags', 'aa_tiffin2food_tags(id2tiffin_id, id2food_tags_id)','joinType'=>'INNER JOIN',),
			'aFoodTagsAll' => array(self::MANY_MANY, 'AFoodTags', 'aa_tiffin2food_tags(id2tiffin_id, id2food_tags_id)','joinType'=>'LEFT OUTER JOIN',),
			'aPhotoses' => array(self::MANY_MANY, 'APhotos', 'aa_tiffin2photos(id2tiffin_id, id2photos_id)', 'joinType'=>'LEFT OUTER JOIN',),
			//'currTiffinPrice' => array(self::STAT, 'APriceTime', 'price_time2tiffin','select' => 'count(time)',),//, price',),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'name' => 'Name',
			'contents' => 'Contents',
			'nutrition' => 'Nutrition',
			'verified_by' => 'Verified By',
			'ranking_index' => 'Ranking Index',
			'tiffin2user_details' => 'Tiffin2user Details',
			'is_deleted' => 'Is Deleted',
			'num_of_orders' => 'Num Of Orders',
			'num_of_reviews' => 'Num Of Reviews',
			'rating_of_tiffin' => 'Rating Of Tiffin',
			'image' => 'Image',
			'ingredient_class' => 'Ingredient Class',
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
		$criteria->compare('name',$this->name,true);
		$criteria->compare('contents',$this->contents,true);
		$criteria->compare('nutrition',$this->nutrition,true);
		$criteria->compare('verified_by',$this->verified_by,true);
		$criteria->compare('ranking_index',$this->ranking_index);
		$criteria->compare('tiffin2user_details',$this->tiffin2user_details,true);
		$criteria->compare('is_deleted',$this->is_deleted,true);
		$criteria->compare('num_of_orders',$this->num_of_orders,true);
		$criteria->compare('num_of_reviews',$this->num_of_reviews,true);
		$criteria->compare('rating_of_tiffin',$this->rating_of_tiffin);
		$criteria->compare('image',$this->image,true);
		$criteria->compare('ingredient_class',$this->ingredient_class,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return ATiffin the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
