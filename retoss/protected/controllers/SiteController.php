<?php

class SiteController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */		
	public $layout='//layouts/column2';
	
	/**
	 * Declares class-based actions.
	 */
	public function actions()
	{
		return array(
			// captcha action renders the CAPTCHA image displayed on the contact page
			'captcha'=>array(
				'class'=>'CCaptchaAction',
				'backColor'=>0xFFFFFF,
			),
			// page action renders "static" pages stored under 'protected/views/site/pages'
			// They can be accessed via: index.php?r=site/page&view=FileName
			'page'=>array(
				'class'=>'CViewAction',
			),
		);
	}

	/**
	 * This is the default 'index' action that is invoked
	 * when an action is not explicitly requested by users.
	 */
	public function actionIndex()
	{
		$modelArr=ABangaloreLocalities::model()->findAll(array(
			'condition'=>'is_deleted = "no"',
			'order'=>'locality_name ASC',
			));
		$locality_arr= array();
		foreach( $modelArr as $singleModel)
		{
			$locality_arr[] = $singleModel->locality_name;
		}
		// renders the view file 'protected/views/site/index.php'
		// using the default layout 'protected/views/layouts/main.php'
		$this->render('index', array('locality_arr'=>$locality_arr));
	}

	/**
	 * This is the action to handle external exceptions.
	 */
	public function actionError()
	{
		if($error=Yii::app()->errorHandler->error)
		{
			if(Yii::app()->request->isAjaxRequest)
				echo $error['message'];
			else
				$this->render('error', $error);
		}
	}

	/**
	 * Displays the contact page
	 */
	public function actionContact()
	{
		$model=new ContactForm;
		if(isset($_POST['ContactForm']))
		{
			$model->attributes=$_POST['ContactForm'];
			if($model->validate())
			{
				//$name='=?UTF-8?B?'.base64_encode($model->name).'?=';
				//$subject='=?UTF-8?B?'.base64_encode($model->subject).'?=';
				//$headers="From: $name <{$model->email}>\r\n".
				//	"Reply-To: {$model->email}\r\n".
				//	"MIME-Version: 1.0\r\n".
				//	"Content-Type: text/plain; charset=UTF-8";
				//mail(Yii::app()->params['adminEmail'],$subject,$model->body,$headers);

				//Yii::ankFileSave("contact-start");
				//Yii::ankFileSave( $model->name );
				//Yii::ankFileSave( $model->email );
				//Yii::ankFileSave( $model->subject );
				//Yii::ankFileSave( $model->body );
				//Yii::ankFileSave("contact-stop");
				AppCommon::sendEmail( Yii::app()->params['adminEmail'] ,"tw.in team" , "contactus".$model->subject, 
				$model->email."\n".$model->name."\n".$model->body, array("contactus") );
				Yii::app()->user->setFlash('contact','Thank you for contacting us. We will respond to you as soon as possible.');
				$this->refresh();
			}
		}
		$this->render('contact',array('model'=>$model));
	}

	/**
	 * Logs out the current user and redirect to homepage.
	 */
	public function actionLogout()
	{
		Yii::app()->user->logout();
		$this->redirect(Yii::app()->homeUrl);
	}

	public function actionLovecooking()
	{
		$this->render('lovecooking');
	}

	public function actionHowitworks()
	{
		$this->render('howitworks');
	}
	

	/** code handling this has been moved to user module
	 * Displays the login page
	 
	public function actionLogin()
	{
		$model=new LoginForm;

		// if it is ajax validation request
		if(isset($_POST['ajax']) && $_POST['ajax']==='login-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}

		// collect user input data
		if(isset($_POST['LoginForm']))
		{
			$model->attributes=$_POST['LoginForm'];
			// validate user input and redirect to the previous page if valid
			if($model->validate() && $model->login())
				$this->redirect(Yii::app()->user->returnUrl);
		}
		// display the login form
		$this->render('login',array('model'=>$model));
	}*/
}