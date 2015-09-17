<?php

class AddressController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';

	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
			'postOnly + delete', // we only allow deletion via POST request
		);
	}

	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
	public function accessRules()
	{
		return array(
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('create',/*'index'*/),
				'users'=>array('@'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id)
	{
		$this->render('view',array(
			'model'=>$this->loadModel($id),
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		if( Yii::app()->getRequest()->getIsAjaxRequest() and $_GET['ajax'] == 1)
		{
			$response = array();
			$model=new AAddress;
			$model->city = 'Bengaluru';
			//get localities list -start
			$modelArr=ABangaloreLocalities::model()->findAll(array(
				'condition'=>'is_deleted = "no"',
				'order'=>'locality_name ASC',
				));
			$locality_array= array();
			foreach( $modelArr as $singleModel)
			{
				$locality_array[ $singleModel->id ] = $singleModel->locality_name;
			}
			$locality_array[ "" ] = "Select any area"; 
			//get localities list -stop
		
		
			// Uncomment the following line if AJAX validation is needed
			// $this->performAjaxValidation($model);

			if(isset($_POST['AAddress']))
			{
				$model->attributes=$_POST['AAddress'];
				$currDateTime = new DateTime();
				$model->creation_time = $currDateTime->format('Y-m-d H:i:s');
				$model->link = AppCommon::getUserDetailsId();
				$model->link_table = "user_details";
				if($model->save())
				{
					//$this->redirect(array('view','id'=>$model->id));
					//sending row html code with checked radio button
					$response["isRecordSaved"] = 1;
					$id_temp = $model->id;
					$Loc_name_temp = $model->address2bangaloreLocalities->locality_name;
					$address_temp = $model->getAddressString( );
					$response["html"] = '<tr><td>'.
					CHtml::activeRadioButton( new CheckoutFirstStageForm() ,'address',array( 'value'=>$id_temp,
					 'required'=> true, 'checked'=>true,'data-locality_name'=>$Loc_name_temp, 'uncheckValue'=> NULL, ) ).
					 '</td><td>'.$address_temp.'</td><td>'.$Loc_name_temp.'</td><tr>';
					$response["locality"] = $Loc_name_temp;
					echo CJSON::encode( $response );
					Yii::app()->end();
				}
			}

			$response["html"] = $this->renderPartial('create',array('model'=>$model, 'locality_array'=>$locality_array,),
			 true, false);
			$response["isRecordSaved"] = 0;
			echo CJSON::encode( $response );
			Yii::app()->end();
		}
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		$model=$this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['AAddress']))
		{
			$model->attributes=$_POST['AAddress'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
		}

		$this->render('update',array(
			'model'=>$model,
		));
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
		$this->loadModel($id)->delete();

		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('AAddress');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new AAddress('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['AAddress']))
			$model->attributes=$_GET['AAddress'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return AAddress the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=AAddress::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param AAddress $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='aaddress-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
