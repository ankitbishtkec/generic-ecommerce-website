<?php

/**
 * This is the model class for table "a_user_login".
 *
 * The followings are the available columns in table 'a_user_login':
 * @property string $id
 * @property string $login_name
 * @property string $pwd
 * @property string $user_login2user_details
 * @property string $is_deleted
 *
 * The followings are the available model relations:
 * @property AUserDetails $userLogin2userDetails
 */
class AUserLogin extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'a_user_login';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('login_name', 'length', 'max'=>80, 'min' => 3,'message' => "Incorrect email (length between 3 and 20 characters)."),
			array('pwd', 'length', 'max'=>200, 'min' => 4,'message' => "Incorrect password (minimal length 4 symbols)."),
			array('login_name', 'email'),
			array('login_name', 'unique', 'message' => "This email already exists."),
			array('user_login2user_details', 'length', 'max'=>20),
			array('is_deleted', 'length', 'max'=>45),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, login_name, pwd, user_login2user_details, is_deleted', 'safe', 'on'=>'search'),
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
			'userLogin2userDetails' => array(self::BELONGS_TO, 'AUserDetails', 'user_login2user_details', 'joinType'=>'INNER JOIN',),
		);
	}
	
	public function scopes()
    {
        return array(
            'scope_select_all'=>array(
            	'select' => 'id, login_name, pwd, is_deleted',
            	'condition'=>'t.is_deleted="no"',
            	'with'=>array( 'userLogin2userDetails' ),
            ),
        );
    }
	
	

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'login_name' => 'Login Name',
			'pwd' => 'Pwd',
			'user_login2user_details' => 'User Login2user Details',
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
		$criteria->compare('login_name',$this->login_name,true);
		$criteria->compare('pwd',$this->pwd,true);
		$criteria->compare('user_login2user_details',$this->user_login2user_details,true);
		$criteria->compare('is_deleted',$this->is_deleted,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return AUserLogin the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
