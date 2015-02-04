<?php

class UploadController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';
        
        private $_client = null;

	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
                        'clientContext + create',  //check to ensure valid project context
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
				'actions'=>array('create','update','index','view','admin','delete','replace','generic','blank'),
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
	public function actionCreate($column)
	{
		$model=new Upload;
                $model->client_id = $this->_client->id;
                $model->formheader = 'Add Image';

		$dir = Yii::app()->basePath.'/../../uploads/';
                $tempdir = Yii::app()->basePath.'/../../temp/';
                $clientdir = $dir . md5($this->_client->name . $this->_client->id) . '/';
                
                if(isset($_POST['Upload']))
		{
			$model->attributes=$_POST['Upload'];
                        $model->file=CUploadedFile::getInstance($model,'file');
                        $model->filename = $model->file->name;
                        $model->file_ext = $model->file->type;
                        $model->file_size = $model->file->size;
                        
                        if(!is_dir($dir)){
                                $oldmask = umask(0);
                                mkdir($dir, 0775);
                                umask($oldmask);
                        }
                        
                        if(!is_dir($tempdir)){
                                $oldmask = umask(0);
                                mkdir($tempdir, 0775);
                                umask($oldmask);
                        }
                        
                        if(!is_dir($clientdir)){
                                $oldmask = umask(0);
                                mkdir($clientdir, 0775);
                                umask($oldmask);
                        }
                        
                        if($model->validate())
                            $uploaded=$model->file->saveAs($tempdir.$model->filename);
                        
			if($model->save())
                            if(rename($tempdir.$model->filename, $clientdir.$model->filename))
                            {
                                $this->_client->saveAttributes(array(
                                        $column=>$model->id,
                                ));
                                Yii::app()->user->setFlash('uploadSubmitted',"<strong>Success!</strong> Your upload has been added to the client." );
				$this->redirect(array('client/view','id'=>$model->uploadClient->id));
                            }
		}

		$this->render('create',array(
			'model'=>$model,
		));
	}
        
        public function actionReplace($id, $column, $uid)
	{
		$model = $this->loadModel($uid);
                $model->formheader = 'Replace Image';
                
                $oldFilename = $model->filename;

                $dir = Yii::app()->basePath.'/../../uploads/';
                $tempdir = Yii::app()->basePath.'/../../temp/';
                $clientdir = $dir . md5($model->uploadClient->name . $model->uploadClient->id) . '/';
                $imagedir = Yii::app()->basePath.'/../../images/';
                $servedir = Yii::app()->basePath.'/../../images/active/';
                
                if(!is_dir($imagedir)){
                                $oldmask = umask(0);
                                mkdir($imagedir, 0775);
                                umask($oldmask);
                        }
                        
                if(!is_dir($servedir)){
                                $oldmask = umask(0);
                                mkdir($servedir, 0775);
                                umask($oldmask);
                        }

		if(isset($_POST['Upload']))
		{
			$model->attributes=$_POST['Upload'];
                        $model->file=CUploadedFile::getInstance($model,'file');
                        $model->filename = $model->file->name;
                        $model->file_ext = $model->file->type;
                        $model->file_size = $model->file->size;
                        
                        if($model->validate())
                            
                            $uploaded=$model->file->saveAs($tempdir.$model->filename);
                            if($model->save())
                            {
                                
                                if(rename($tempdir.$model->filename, $clientdir.$model->filename))
                                {
                                    if(file_exists($clientdir.$oldFilename))
                                        unlink($clientdir.$oldFilename);
                                    
                                    if($model->uploadClient->active == 1)
                                    {
                                        copy($clientdir.$model->filename, $servedir.$column.'.jpg');
                                    }
                                    
                                    $model->uploadClient->saveAttributes(array(
                                            $column=>$model->id,
                                    ));
                                    
                                    Yii::app()->user->setFlash('success',"<strong>Success!</strong> Your upload has been replaced." );
                                    $this->redirect(array('client/view','id'=>$model->uploadClient->id));
                                }
                            }
                                Yii::app()->user->setFlash('error',"<strong>Fail!</strong> Your upload couldn't be replaced." );
                } 

		$this->render('create',array(
			'model'=>$model,
                    ));
	}
        
        public function actionGeneric($uid)
        {
            $model = $this->loadModel($uid);
            $model->scenario = 'generic';
            
            $oldFilename = $model->filename;

            $dir = Yii::app()->basePath.'/../../uploads/';
            $clientdir = $dir . md5($model->uploadClient->name . $model->uploadClient->id) . '/';
            $imagedir = Yii::app()->basePath.'/../../images/';
            $servedir = Yii::app()->basePath.'/../../images/active/';
                
                            $model->filename = 'generic_skin.jpg';
                            $model->file_size = 61125;
                            if($model->save())
                            {
                                if(copy($imagedir.$model->filename, $clientdir.$model->filename))
                                {
                                    if(file_exists($clientdir.$oldFilename))
                                        unlink($clientdir.$oldFilename);
                                    
                                    if($model->uploadClient->active == 1)
                                    {
                                        copy($imagedir.$model->filename, $servedir.'ad_3.jpg');
                                    }
                                }
                            } else {
                                throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
                            }
                        
            $this->redirect(array('client/view','id'=>$model->uploadClient->id));
        }
        
        public function actionBlank($uid)
        {
            $model = $this->loadModel($uid);
            $model->scenario = 'generic';
            
            $oldFilename = $model->filename;

            $dir = Yii::app()->basePath.'/../../uploads/';
            $clientdir = $dir . md5($model->uploadClient->name . $model->uploadClient->id) . '/';
            $imagedir = Yii::app()->basePath.'/../../images/';
            $servedir = Yii::app()->basePath.'/../../images/active/';
                
                            $model->filename = 'Eyewitness-Weather-120x60.jpg';
                            $model->file_size = 61125;
                            if($model->save())
                            {
                                if(copy($imagedir.$model->filename, $clientdir.$model->filename))
                                {
                                    if(file_exists($clientdir.$oldFilename))
                                        unlink($clientdir.$oldFilename);
                                    
                                    if($model->uploadClient->active == 1)
                                    {
                                        copy($imagedir.$model->filename, $servedir.'ad_3.jpg');
                                    }
                                }
                            } else {
                                throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
                            }
                        
            $this->redirect(array('client/view','id'=>$model->uploadClient->id));
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

		if(isset($_POST['Upload']))
		{
			$model->attributes=$_POST['Upload'];
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
		if(Yii::app()->request->isPostRequest)
		{
			// we only allow deletion via POST request
			$this->loadModel($id)->delete();

			// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
			if(!isset($_GET['ajax']))
				$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
		}
		else
			throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('Upload');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Upload('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Upload']))
			$model->attributes=$_GET['Upload'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($id)
	{
		$model=Upload::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param CModel the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='upload-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
        
        public function filterClientContext($filterChain)
	{   
		//set the project identifier based on either the GET input 
	    //request variables   
		if(isset($_GET['id']))
			$this->loadClient($_GET['id']);   
		else
			throw new CHttpException(403,'Must specify a valid client before performing this action.');
			
		//complete the running of other filters and execute the requested action
			
		$filterChain->run(); 
	} 
        
        protected function loadClient($clientId)	 
	{
		//if the project property is null, create it based on input id
		if($this->_client===null)
		{
			$this->_client=Client::model()->findByPk($clientId);
			if($this->_client===null)
                        {
				throw new CHttpException(404,'The requested client does not exist.'); 
			}
		}

		return $this->_client; 
	}
}
