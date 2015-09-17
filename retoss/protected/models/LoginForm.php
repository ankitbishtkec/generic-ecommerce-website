<?php

/**
 * LoginForm class.
 * LoginForm is the data structure for keeping
 * user login form data. It is used by the 'login' action of 'SiteController'.
 */
class LoginForm extends CFormModel//this class LoginForm is the login form of application
{
	public $username;
	public $password;
	public $rememberMe;

	private $_identity;

	/**
	 * Declares the validation rules.
	 * The rules state that username and password are required,
	 * and password needs to be authenticated.
	 */
	public function rules()
	{
		return array(
			// username and password are required
			array('username, password', 'required'),
			// rememberMe needs to be a boolean
			array('rememberMe', 'boolean'),
			// password needs to be authenticated
			array('password', 'authenticate'),
		);
	}

	/**
	 * Declares attribute labels.
	 */
	public function attributeLabels()
	{
		return array(
			'rememberMe'=>UserModule::t("Remember me next time"),
			'username'=>UserModule::t("Email"),
			'password'=>UserModule::t("Password"),
		);
	}

	/**
	 * Authenticates the password.
	 * This is the 'authenticate' validator as declared in rules().
	 * returning true false does not stops proceeding to action. to stop add error to attribute.
	 */
	public function authenticate($attribute,$params)
	{
		if(!$this->hasErrors())
		{
			$this->_identity=new UserIdentity($this->username,$this->password);
			$this->_identity->authenticate();
			
			switch($this->_identity->errorCode)
			{
				case UserIdentity::ERROR_NONE:
					$duration=$this->rememberMe ? Yii::app()->controller->module->rememberMeTime : 0;
					Yii::app()->user->login($this->_identity,$duration);
					AppCommon::mergeCookieAndDbCart();//on login merge the db and cookie carts 
					break;
				case UserIdentity::ERROR_EMAIL_INVALID:
					$this->addError("username",UserModule::t("Email is incorrect."));
					break;
				case UserIdentity::ERROR_STATUS_NOTACTIV:
					$this->addError("username",UserModule::t("You account is not activated."));
					break;
				case UserIdentity::ERROR_STATUS_BAN:
					$this->addError("username",UserModule::t("You account is blocked."));
					break;
				case UserIdentity::ERROR_PASSWORD_INVALID:
					$this->addError("password",UserModule::t("Password is incorrect."));
					break;
			}
			if($this->_identity->errorCode===UserIdentity::ERROR_NONE)
				return true;
			else
				return false;
		}
	}

}
