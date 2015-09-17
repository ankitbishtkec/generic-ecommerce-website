<?php
/**
 * RegistrationForm class.
 * RegistrationForm is the data structure for keeping
 * user registration form data. It is used by the 'registration' action of 'UserController'.
 */
class RegistrationForm extends CFormModel {
	
	public $firstName;	
	public $email;
	public $password;
	public $verifyPassword;
	public $verifyCode;
	
	public function rules() {
		$rules = array(
			array('firstName, password, verifyPassword, email', 'required'),
			array('firstName', 'length', 'max'=>45, 'min' => 3,'message' => "Incorrect (length between 3 and 20 characters)."),
			array('password','length', 'max'=>15, 'min' => 6,'message' => "Incorrect (length between 6 and 15 characters)."),
			array('email', 'email'),
			array('email', 'uniqueUserDefinedFunc'),
			array('verifyPassword', 'compare', 'compareAttribute'=>'password', 'message' => UserModule::t("Retype Password is incorrect.")),
			array('firstName', 'match', 'pattern' => '/^[A-Za-z ]+$/u','message' => UserModule::t("Incorrect symbols only aplhabets and spaces are allowed.")),
		);
		//if (!(isset($_POST['ajax']) && $_POST['ajax']==='registration-form')) {
		//	array_push($rules,array('verifyCode', 'captcha', 'allowEmpty'=>!UserModule::doCaptcha('registration')));
		//}
		return $rules;
	}

	/**
	 * Declares attribute labels.
	 */
	public function attributeLabels()
	{
		return array(
			'firstName'=>UserModule::t("First name"),
			'email'=>UserModule::t("Email"),
			'password'=>UserModule::t("Password"),
			'verifyPassword'=>UserModule::t("Retype password"),
			'verifyCode'=>UserModule::t("Verification code"),
		);
	}

	/**
	 * Authenticates the password.
	 * This is the 'authenticate' validator as declared in rules().
	 */
	public function uniqueUserDefinedFunc($attribute,$params)
	{
		$record = AUserLogin::model()->findByAttributes( array('login_name'=> $this -> email));
		if( $record != null)
		{
			$this->addError("email",UserModule::t("Account with this email already exists.Kindly use a different email."));
			return false;
		}
		else
			return false;
	}	
}