<?php

class OrderController extends Controller
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
			array('allow',  // allow all users to perform 'index' and 'view' actions
				'actions'=>array('index','view'),
				'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('create','update'),
				'users'=>array('@'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('admin','delete'),
				'users'=>array('admin'),
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
		$sm=Yii::app()->getSecurityManager();
		$orderId = $id;
		$selectedOrders = null;
		
		if( isset( $orderId ) )
		{
			if( ($orderId=$sm->validateData($orderId)) == false )//valdate if orderId is not forged
			{
				throw new CHttpException(404,'The requested page does not exist. In case of any help do contact us.');
				Yii::app()->end();
			}
			$selectedOrders = AOrder::model()->findAll( array(
					'order'=> 'id' ,
	        		'condition'=>'is_deleted = "no" '.
	        		' AND  order_unique_id = "'.$orderId.'" '.
	        		' AND  status = "order_confirmed" ',//'order_confirmed' status
	    			) 
				);
			if( !( isset( $selectedOrders ) ) || count( $selectedOrders ) < 1 )//no orders selected
			{
				throw new CHttpException(404,'The requested page does not exist. In case of any help do contact us.');
				Yii::app()->end();
			}
			$this->render('view',array(
				'orderId'=>$orderId,
				'selectedOrders'=>$selectedOrders,
			));
		}
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		Yii::app()->end();
		$model=new AOrder;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['AOrder']))
		{
			$model->attributes=$_POST['AOrder'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
		}

		$this->render('create',array(
			'model'=>$model,
		));
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		Yii::app()->end();
		$model=$this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['AOrder']))
		{
			$model->attributes=$_POST['AOrder'];
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
		Yii::app()->end();
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
		Yii::app()->end();
		$dataProvider=new CActiveDataProvider('AOrder');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		Yii::app()->end();
		$model=new AOrder('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['AOrder']))
			$model->attributes=$_GET['AOrder'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return AOrder the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=AOrder::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param AOrder $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='aorder-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
