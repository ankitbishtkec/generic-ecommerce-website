<?php

class RegistrationController extends Controller
{
	public $defaultAction = 'registration';
	
	/**
	 * Declares class-based actions.
	 */
	public function actions()
	{
		return array(
			'captcha'=>array(
				'class'=>'CCaptchaAction',
				'backColor'=>0xFFFFFF,
			),
		);
	}
	/**
	 * Registration user
	 */
	public function actionRegistration() {
            $model = new RegistrationForm;
            
			// ajax validator
			if(isset($_POST['ajax']) && $_POST['ajax']==='registration-form')
			{
				echo CActiveForm::validate( $model );
				Yii::app()->end();
			}
			
		    if (Yii::app()->user->id != null) {
		    	$this->redirect(Yii::app()->controller->module->profileUrl);
		    } else {
		    	if(isset($_POST['RegistrationForm'])) {
					$model->attributes=$_POST['RegistrationForm'];
					if( $model->validate() )
					{
						$loginRecord = new AUserLogin;
						$loginRecord->login_name = $model->email;
						$loginRecord->pwd = UserModule::encrypting( $model->password );
						//$loginRecord->user_login2user_details
						$loginRecord->is_deleted = "no";
						
						$timeRecord = new TimeDetails;
						$timeRecord -> created_datetime = date('Y-m-d H:i:s');
						$timeRecord -> last_updated_datetime = date('Y-m-d H:i:s');
						$timeRecord -> last_used_datetime = date('Y-m-d H:i:s');
						$timeRecord -> is_deleted = "no";
						
						$emailRecord = new AEmail;
						$emailRecord -> email = $model->email;
						$emailRecord -> is_deleted = "no";
						
						$detailsRecord = new AUserDetails;
						$detailsRecord -> is_active = 
								((Yii::app()->controller->module->activeAfterRegister)?User::STATUS_ACTIVE:User::STATUS_NOACTIVE);
						$detailsRecord -> user_type = 0;
						$detailsRecord -> first_name = $model->firstName;
						//$detailsRecord -> user_details2time_details
						$detailsRecord -> activkey = UserModule::encrypting(microtime().$model->password);
						$detailsRecord -> sms_email_setting = '111111';
						$detailsRecord -> num_of_visits = 0;
						$detailsRecord -> is_deleted = "no";
						
						if ( $this -> saveAllRecords( $loginRecord, $detailsRecord, $emailRecord, $timeRecord ) ) 
						{
							if (Yii::app()->controller->module->sendActivationMail) 
							{
								$activation_url = $this->createAbsoluteUrl('/user/activation/activation',array("activkey" => $detailsRecord -> activkey, "email" => $model->email));
								UserModule::sendMail($model->email,UserModule::t("You registered from {site_name}",array('{site_name}'=>Yii::app()->name)),UserModule::t("Please activate you account go to {activation_url}",array('{activation_url}'=>$activation_url)));
								Yii::ankFileSave( $activation_url );
							}
							
							if ((Yii::app()->controller->module->loginNotActiv||(Yii::app()->controller->module->activeAfterRegister&&Yii::app()->controller->module->sendActivationMail==false))&&Yii::app()->controller->module->autoLogin) 
							{
									$identity=new UserIdentity($model->email ,$model->password);
									$identity->authenticate();
									Yii::app()->user->login($identity,0);
									$this->redirect(Yii::app()->controller->module->returnUrl);
							} else 
							{
								if (!Yii::app()->controller->module->activeAfterRegister&&!Yii::app()->controller->module->sendActivationMail) 
								{
									Yii::app()->user->setFlash('registration',UserModule::t("Thank you for your registration. Contact Admin to activate your account."));
								} 
								elseif(Yii::app()->controller->module->activeAfterRegister&&Yii::app()->controller->module->sendActivationMail==false) 
								{
									Yii::app()->user->setFlash('registration',UserModule::t("Thank you for your registration. Please {{login}}.",array('{{login}}'=>CHtml::link(UserModule::t('Login'),Yii::app()->controller->module->loginUrl))));
								} 
								elseif(Yii::app()->controller->module->loginNotActiv) 
								{
									Yii::app()->user->setFlash('registration',UserModule::t("Thank you for your registration. Please check your email or login."));
								} 
								else 
								{
									Yii::app()->user->setFlash('registration',UserModule::t("Thank you for your registration. Please check your email."));
								}
								$this->refresh();
							}
						}
					}
				}
			    $this->render('/user/registration',array('model'=>$model ));
			    //$this->render('login',array( 'model'=>$model ));
		    }
	}	
	
	//return true if success else shows error and refreshes page.
	private function saveAllRecords( $loginRecord, $detailsRecord, $emailRecord, $timeRecord ) 
	{
		$transaction=Yii::app()->db->beginTransaction();
		try
		{
					if( $timeRecord->save() )
					{
						$detailsRecord -> user_details2time_details = $timeRecord -> id;
						if(  $detailsRecord->save() )
						{
							$detailsRecord->unique_name = $detailsRecord->first_name."-".$detailsRecord->id;
							if( !($detailsRecord->save()) )//saving unique name
							{
								throw new Exception('error');
							}
							
			//add in wallet 50 rupees for new registration
			AppCommonWallet::createWalletRecord( 'credit', 50, 50, 'registration_bonus', null, 
				$detailsRecord -> id, date('Y-m-d H:i:s'), '2016-01-01 00:00:00', 
				null, $detailsRecord -> id , 'wallet');
			//***
							$loginRecord->user_login2user_details = $detailsRecord -> id;
							if( $loginRecord->save() )
							{
								$emailRecord->link = $detailsRecord->id;
								$emailRecord->link_table = "user_details";
								if( $emailRecord->save() )
								{
    								$transaction->commit();
    								return true;
								}
								else
									{
										throw new Exception('error');
									}
							}
							else
								{
									throw new Exception('error');
								}
						}
						else
							{
								throw new Exception('error');
							} 
					}
					else
						{
							throw new Exception('error');
						} 
		}
		catch(Exception $e)
		{
			Yii::ankFileSave($e->getMessage());
			Yii::app()->user->setFlash('registration',UserModule::t("Some problem happened. Kindly try again."));
			$transaction->rollback();
			$this->refresh();
		}
	}
}