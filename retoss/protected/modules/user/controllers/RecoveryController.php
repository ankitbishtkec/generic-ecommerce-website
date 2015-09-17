<?php

class RecoveryController extends Controller
{
	public $defaultAction = 'recovery';
	
	/**
	 * Recovery password
	 */
	public function actionRecovery () {
		$form = new UserRecoveryForm;
		if (Yii::app()->user->id) {
		    	$this->redirect(Yii::app()->controller->module->returnUrl);
		    } else {
				$email = ((isset($_GET['email']))?$_GET['email']:'');
				$activkey = ((isset($_GET['activkey']))?$_GET['activkey']:'');
				if ($email&&$activkey) {
					$form2 = new UserChangePassword;
		    		$find = AUserLogin::model()->scope_select_all()->findByAttributes( array('login_name'=> $email));
		    		if(isset($find)&&$find->userLogin2userDetails->activkey==$activkey) {
			    		if(isset($_POST['UserChangePassword'])) {
							$form2->attributes=$_POST['UserChangePassword'];
							if($form2->validate()) {
								$find->pwd = Yii::app()->controller->module->encrypting($form2->password);
								$find->userLogin2userDetails->activkey=Yii::app()->controller->module->encrypting(microtime().$form2->password);
								if ($find->userLogin2userDetails->is_active==0) {
									$find->userLogin2userDetails->is_active = 1;
								}
								$find->save();
								$find->userLogin2userDetails->save();
								Yii::app()->user->setFlash('recoveryMessage',UserModule::t("New password is saved."));
								$this->redirect(Yii::app()->controller->module->recoveryUrl);
							}
						} 
						$this->render('changepassword',array('form'=>$form2));
		    		} else {
		    			Yii::app()->user->setFlash('recoveryMessage',UserModule::t("Incorrect recovery link."));
						$this->redirect(Yii::app()->controller->module->recoveryUrl);
		    		}
		    	} else {
			    	if(isset($_POST['UserRecoveryForm'])) {
			    		$form->attributes=$_POST['UserRecoveryForm'];
			    		if($form->validate()) {
			    			$user = AUserLogin::model()->scope_select_all()->findByAttributes( array('login_name'=> $form->login_or_email));
							$activation_url = 'http://' . $_SERVER['HTTP_HOST'].$this->createUrl(implode(Yii::app()->controller->module->recoveryUrl),array("activkey" => $user->userLogin2userDetails->activkey, "email" => $user->login_name));
							
							$subject = UserModule::t("You have requested the password recovery for {site_name}",
			    					array(
			    						'{site_name}'=>Yii::app()->name,
			    					));
			    			$message = UserModule::t("Hi, \n You have requested the password recovery for {site_name}. To receive a new password, go to {activation_url}. \n Regards, \n tw.in team",
			    					array(
			    						'{site_name}'=>Yii::app()->name,
			    						'{activation_url}'=>$activation_url,
			    					));
							
			    			UserModule::sendMail($user->login_name,$subject,$message);
			    			
							Yii::app()->user->setFlash('recoveryMessage',UserModule::t("Please check your email. Instructions has been sent to your email address."));
			    			$this->refresh();
			    		}
			    	}
		    		$this->render('recovery',array('form'=>$form));
		    	}
		    }
	}

}