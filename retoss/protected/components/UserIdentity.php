<?php

/**
 * UserIdentity represents the data needed to identity a user.
 * It contains the authentication method that checks if the provided
 * data can identity the user.
 */
class UserIdentity extends CUserIdentity
{
	
	//we always require real name, email, db ids and user type
	//getname, getemail, getId, getusertype
	
	public $email;
	public $userType;
	public $realName;
	public $dbIds;//(a_user_login->id)_(a_user_details->id)
	
	
	const ERROR_EMAIL_INVALID=3;
	const ERROR_STATUS_NOTACTIV=4;
	const ERROR_STATUS_BAN=5;
	
	public function getEmail()
	{
		return $this->email;
	}

	public function getUserType()
	{
		return $this->userType;
	}
	
	public function getName()
	{
		return $this->realName;
	}

	public function getId()
	{
		return $this->dbIds;
	}	
		
	private function lastVisit( $timeRecordId ) 
	{
		$timeRecord = TimeDetails::model()->findByPk( $timeRecordId );
		if( $timeRecord === null)
			return;
		$currDatetime = new DateTime();
		$timeRecord->last_used_datetime = $currDatetime->format('Y-m-d H:i:s');
		$timeRecord->save();
	}
	
	//$a_user_login_record
	//returns the error code
	public function setAllProperties( $record )
	{
		$record_details = $record;
		if($record===null)
			return self::ERROR_EMAIL_INVALID;

		$this->email = $this->username;		
		$this->userType = $record_details->user_type;
		$this->realName = $record_details->first_name." ".$record_details->last_name;;
		$this->dbIds = $record->id."_".$record_details->id;
		$record_details->num_of_visits = $record_details->num_of_visits + 1;
		$record_details->save();
		
		$this->setPersistentStates( array(
										'email'=> $this->getEmail(),
										'userType'=>$this->getUserType(),
										));
		$this->lastVisit( $record_details->user_details2time_details );
		//merging moved to loginform after user has been created so that guest user logic can work.
		//AppCommon::mergeCookieAndDbCart();//on login merge the db and cookie carts 
		return self::ERROR_NONE;
	}
	/**
	 * Authenticates a user.
	 * The example implementation makes sure if the username and password
	 * are both 'demo'.
	 * In practical applications, this should be changed to authenticate
	 * against some persistent user identity storage (e.g. database).
	 * @return boolean whether authentication succeeds.
	 */
	public function authenticate()
	{
		//$this->username represents email and should be email always
		$record = AUserLogin::model()->scope_select_all()->findByAttributes( array('login_name'=> $this -> username));
		
		if($record===null)
			$this->errorCode=self::ERROR_EMAIL_INVALID;
		elseif( $record->pwd !== Yii::app()->getModule('user')->encrypting( $this->password ) )
			$this->errorCode=self::ERROR_PASSWORD_INVALID;
		else if($record->userLogin2userDetails->is_active == 0 && Yii::app()->getModule('user')->loginNotActiv==false)
			$this->errorCode=self::ERROR_STATUS_NOTACTIV;
		else if($record->userLogin2userDetails->is_active == -1)
			$this->errorCode=self::ERROR_STATUS_BAN;
		else
			$this->errorCode=self::ERROR_NONE;
		
		if($this->errorCode === self::ERROR_NONE)
			$this->errorCode = $this->setAllProperties( $record->userLogin2userDetails );
		return !$this->errorCode;
	}
}