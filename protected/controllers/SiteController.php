<?php
/**
 * Created by PhpStorm.
 */
/**
 * Class SiteController
 *
 */
class SiteController extends Controller
{
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
		// renders the view file 'protected/views/site/index.php'
		// using the default layout 'protected/views/layouts/main.php'
		$this->render('index');
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
	public function actionEmployees()
	{
		$this->render('viewEmployees',array());
	}
	public function actionMeeting()
	{
		$this->render('viewMeetings',array());
	}

	/**
	 * inserts people into DB
	 */
	public function actionInsertEmployee()
	{
		if(isset($_POST['NameInput']))
		{
			$newman=new People();
			$newman->SaveAs();
			//$newman->save();

			$this->redirect($this->createUrl('site/employees'));
		}
		else
		{
			$newman=new People();
			$this->render('viewInsertEmployeeForm',
				[
					'model'		=>$newman,
					'optionsM'	=>Meets::model()->findAll(),
					'optionsD'	=>Department::model()->findAll(),
				]);
		}
	}

	/**
	 * добавление встречи
	 */
	public function actionInsertMeeting()
	{
		if(isset($_POST['yt0']))
		{
			$newmeet=new Meets();
			$newmeet->saveAs();
			$this->redirect($this->createUrl('site/meeting'));
		}
		else
		{
			$this->render('viewInsertMeetingForm', [
				'optionsP'=>People::model()->findAll(),
				'optionsR'=>Room::model()->findAll(),
			]);
		}
	}

	/**
	 * удаление записи
	 * @param $id ключ сотрудника.
	 *
	 */
	public function actionDeleteEmployee($id)
	{
		People::model()->findByPk($id)->delete();
		$this->redirect($this->createUrl('site/employees'));
	}

	/**
	 * удаление записи
	 * @param $id ключ сотрудника.
	 *
	 */
	public function actionDeleteMeeting($id)
	{
		Meets::model()->findByPk($id)->delete();
		$this->redirect($this->createUrl('site/meeting'));
	}

	/**
	 * редактирование записи сотрудника
	 * @param ключ записи в БД
	 */
	public function actionEditEmployee($id){
		if(isset($_POST['yt0']))
		{
			$newman=People::model()->findByPk(intval($_POST['ID']));
			if (!$newman)
			{
				print("error. employee id=$id not found");
				die();
				$this->redirect(Yii::app()->homeUrl);
			}
			$newman->saveAs();

			$this->redirect($this->createUrl('site/employees'));
		}
		else
		{
			$newman=People::model()->findByPk($id);

			$this->render('viewInsertEmployeeForm',
				[
					'model'		=>	$newman,
					'optionsM'	=>Meets::model()->findAll(),
					'optionsD'	=>Department::model()->findAll(),
				]);
		}
	}
	/**
	 * @param $id ключ в таблице встреч
	 */
	public function actionEditMeeting($id){
		if(isset($_POST['yt0']))
		{
			$id=intval($_POST['ID']);
			$newmeet=Meets::model()->findByPk(intval($_POST['ID']));
			$newmeet->saveAs();

			$this->redirect($this->createUrl('site/meeting'));
		}
		else
		{
			$this->render('viewInsertMeetingForm',
				[
					'optionsP'=>People::model()->findAll(),
					'optionsR'=>Rooms::model()->findAll(),
				]);
		}
	}
	/**
	 * viewCriteriaForm действие  ' поиск больших встреч'
	 */
	public function actionCriteriaForm()
	{
		$model=new ModelCriteria;
		if(isset($_POST['ModelCriteria'])) {
			$model->attributes = $_POST['ModelCriteria'];
			if ($model->validate()) {
				$model->QueryNames();
				$model->QueryBuddies();
				$this->render('viewCriteriaForm',array('model'=>$model));
				return;
			}
		}
		$this->render('viewCriteriaForm',array('model'=>$model));
	}

}