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
		$this->render('viewEmployees',array('employees'=>People::model()->findAll()));
	}
	public function actionMeeting()
	{
		$this->render('viewMeetings',array('meetings'=>Meets::model()->findAll()));
	}

	/**
	 * inserts people into DB
	 */
	public function actionInsertEmployee()
	{
		$newman=new People();
		if(isset($_POST['ID']))
		{
			$newman->SaveAs();
			$this->redirect($this->createUrl('site/employees'));
		}
		else
		{
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
		$newmeet=new Meets();
		if(isset($_POST['ID']))
		{
			$newmeet->saveAs();
			$this->redirect($this->createUrl('site/meeting'));
		}
		else
		{
			$this->render('viewInsertMeetingForm', [
				'model'		=>$newmeet,
				'optionsP'	=>People::model()->findAll(),
				'optionsR'	=>Room::model()->findAll(),
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
	 * @throws Exception
	 */
	public function actionEditEmployee($id){
		if(isset($_POST['ID']))
		{
			$newman=People::model()->findByPk(intval($_POST['ID']));
			if (!$newman)
				throw new Exception("error. edit employee id=$id not found");
			$newman->saveAs();

			$this->redirect($this->createUrl('site/employees'));
		}
		else
		{
			$newman=People::model()->findByPk($id);
			if (!$newman)
				throw new Exception("error. edit employee id=$id not found");

			$this->render('viewInsertEmployeeForm',
				[
					'model'		=>	$newman,
					'optionsM'	=>Meets::model()->findAll(),
					'optionsD'	=>Department::model()->findAll(),
				]);
		}
	}
	/**
	 *	редактирование записи встречи.
	 * @param $id ключ в таблице встреч
	 * @throws Exception
	 */
	public function actionEditMeeting($id){

		if(isset($_POST['ID']))
		{
			$id=intval($_POST['ID']);
			$newmeet=Meets::model()->findByPk($id);
			if (!$newmeet)
				throw new Exception("error. edit meeting id=$id not found");
			$newmeet->saveAs();
			$this->redirect($this->createUrl('site/meeting'));
		}
		else
		{
			$newmeet=Meets::model()->findByPk($id);
			if (!$newmeet)
				throw new Exception("error. edit meeting id=$id not found");
			$this->render('viewInsertMeetingForm',
				[
					'model'		=>	$newmeet,
					'optionsP'=>People::model()->findAll(),
					'optionsR'=>Room::model()->findAll(),
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

	/**
	 * actionRoomExplore находит дерево комнат
	 * @throws Exception
	 */
	public function actionRoomExplore()
	{
		if(isset($_GET['id']) ) {
			$id=$_GET['id'];
			$model=Room::model()->findByPk($id);
			if (!$model)
				throw new Exception("error. room id=$id not found");
			$this->render('viewRoomTree',array('model'=>$model,));
		}
		else{
			$this->render('viewRoomList',array('items'=>Room::model()->findAll(),));
		}
	}

	/**
	 * actionRoomDelete удаляет комнату
	 * @throws Exception
	 */
	public function actionRoomDelete()
	{
		if(isset($_GET['id'])) {
			$model = Room::model()->findByPk($_GET['id']);
			if ($model) {
				$model->delete();
				$this->redirect($this->createUrl('site/roomExplore'));
			}
		}
		else
		{
			throw new Exception("error. room not found");
		}
	}
	/**
	 * actionRoomExplore находит дерево комнат
	 * @throws Exception
	 */
	public function actionDeptExplore()
	{
		if(isset($_GET['id']) ) {
			$id=$_GET['id'];
			$model=Department::model()->findByPk($id);
			if (!$model)
				throw new Exception("error. room id=$id not found");
			$this->render('viewDepartmentTree',array('model'=>$model,));
		}
		else{
			$this->render('viewDepartmentList',array('items'=>Department::model()->findAll(),));
		}
	}

	/**
	 * actionDeptDelete удаляет отдел
	 * @throws Exception
	 */
	public function actionDeptDelete()
	{
		if(isset($_GET['id'])) {
			$model = Department::model()->findByPk($_GET['id']);
			if ($model) {
				$model->delete();
				$this->redirect($this->createUrl('site/deptExplore'));
			}
		}
		else
		{
			throw new Exception("error. Department not found");
		}
	}

}