<?php

/**
 * This is the model class for table "a_address".
 *
 * The followings are the available columns in table 'a_address':
 * @property string $id
 * @property string $house_flat_num
 * @property string $house_name
 * @property string $society_apartment_name
 * @property string $street_name1
 * @property string $street_name2
 * @property string $locality
 * @property string $landmark
 * @property string $city
 * @property integer $pin
 * @property string $state
 * @property string $country
 * @property integer $is_active
 * @property string $creation_time
 * @property string $is_deleted
 * @property string $meta_data
 * @property string $link
 * @property string $link_table
 * @property string $address2bangalore_localities
 *
 * The followings are the available model relations:
 * @property ABangaloreLocalities $address2bangaloreLocalities
 * @property AOrder[] $aOrders
 */
class AAddress extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'a_address';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('pin, is_active', 'numerical', 'integerOnly'=>true),
			array('house_flat_num', 'length', 'max'=>10),
			array('house_name, society_apartment_name, city, state', 'length', 'max'=>50),
			array('street_name1, street_name2, locality', 'length', 'max'=>100),
			array('landmark', 'length', 'max'=>200),
			array('country', 'length', 'max'=>30),
			array('is_deleted, meta_data, link_table', 'length', 'max'=>45),
			array('link, address2bangalore_localities', 'length', 'max'=>20),
			array('creation_time', 'safe'),
			// ankit added
			array('city, address2bangalore_localities, landmark, street_name1, street_name2', 'required'),
			array('address2bangalore_localities', 'checkValidLocality'),
			array('city, address2bangalore_localities, landmark, street_name1, street_name2', 'match', 'pattern' => '/^[A-Za-z0-9,-\/ ]+$/u','message' => CHtml::encode("Incorrect symbols only alphabets, numerals, spaces, '/' '-' and ',' are allowed.")),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, house_flat_num, house_name, society_apartment_name, street_name1, street_name2, locality, landmark, city, pin, state, country, is_active, creation_time, is_deleted, meta_data, link, link_table, address2bangalore_localities', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * Checks if the given value is empty.
	 * A value is considered empty if it is null, an empty array, or the trimmed result is an empty string.
	 * Note that this method is different from PHP empty(). It will return false when the value is 0.
	 * @param mixed $value the value to be checked
	 * @param boolean $trim whether to perform trimming before checking if the string is empty. Defaults to false.
	 * @return boolean whether the value is empty
	 */
	function isEmpty($value,$trim=false)
	{
		return $value===null || $value===array() || $value==='' || $trim && is_scalar($value) && trim($value)==='';
	}

	/**
	 * Authenticates the locality.
	 * This is the 'checkValidLocality' validator as declared in rules().
	 * returning true false does not stops proceeding to action. to stop add error to attribute.
	 */
	public function checkValidLocality($attribute,$params)
	{
		if( isset( $this->address2bangalore_localities ) &&  !( $this->isEmpty( $this->address2bangalore_localities ) ) )
		{
			$modelArr=ABangaloreLocalities::model()->findAll(array(
				'condition'=>'is_deleted = "no" and id = '.$this->address2bangalore_localities,
				));
		}
		if( ! isset( $modelArr ) || count( $modelArr ) < 1)// no such record for locality exists
			$this->addError("address2bangalore_localities",CHtml::encode("Kindly select a valid locality."));
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'address2bangaloreLocalities' => array(self::BELONGS_TO, 'ABangaloreLocalities', 'address2bangalore_localities','joinType'=>'INNER JOIN',),
			'aOrders' => array(self::HAS_MANY, 'AOrder', 'order2address'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'house_flat_num' => 'House/ flat Number',
			'house_name' => 'House Name',
			'society_apartment_name' => 'Building Name',
			'street_name1' => 'Address Line 1',
			'street_name2' => 'Address Line 2',
			'locality' => 'Locality',
			'landmark' => 'Landmark',
			'city' => 'City',
			'pin' => 'Pin',
			'state' => 'State',
			'country' => 'Country',
			'is_active' => 'Is Active',
			'creation_time' => 'Creation Time',
			'is_deleted' => 'Is Deleted',
			'meta_data' => 'Meta Data',
			'link' => 'Link',
			'link_table' => 'Link Table',
			'address2bangalore_localities' => 'Select any area ( mandatory )',
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
		$criteria->compare('house_flat_num',$this->house_flat_num,true);
		$criteria->compare('house_name',$this->house_name,true);
		$criteria->compare('society_apartment_name',$this->society_apartment_name,true);
		$criteria->compare('street_name1',$this->street_name1,true);
		$criteria->compare('street_name2',$this->street_name2,true);
		$criteria->compare('locality',$this->locality,true);
		$criteria->compare('landmark',$this->landmark,true);
		$criteria->compare('city',$this->city,true);
		$criteria->compare('pin',$this->pin);
		$criteria->compare('state',$this->state,true);
		$criteria->compare('country',$this->country,true);
		$criteria->compare('is_active',$this->is_active);
		$criteria->compare('creation_time',$this->creation_time,true);
		$criteria->compare('is_deleted',$this->is_deleted,true);
		$criteria->compare('meta_data',$this->meta_data,true);
		$criteria->compare('link',$this->link,true);
		$criteria->compare('link_table',$this->link_table,true);
		$criteria->compare('address2bangalore_localities',$this->address2bangalore_localities,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return AAddress the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	

	/**
	 * gets only those addresses for a user for which both address2bangaloreLocalities and
	 * address record are not deleted.
	 *
	 * Returns array( addrId => array( locality, addrText ) )
	 */
	public static function getAllowedAddressForUser( $userId = NULL )
	{
		$response = array();
		if( isset( $userId ) )
		{
			$selectedAddresses = AAddress::model()->findAll( array(
	        		'with'=>
    	    		array(
        			'address2bangaloreLocalities'=>
    	    			array(
        				'on'=>'address2bangaloreLocalities.is_deleted = "no" AND 
        				t.is_deleted = "no" AND t.link_table = "user_details"  AND t.link = '.$userId.' ',	
							),
						),
    				) );
			foreach ( $selectedAddresses as $row ) 
			{
				$response[ $row->id ][] = $row->address2bangaloreLocalities->locality_name;
				$response[ $row->id ][] = $row->getAddressString( );
			}
		}
		return $response;
	}
	
	/**
	 * non-static function
	 * gets address string.
	 *
	 * Returns address string
	 */
	public function getAddressString( )
	{
		return $this->street_name1." ".$this->street_name2." ".$this->landmark." ".$this->city;
	}
}
