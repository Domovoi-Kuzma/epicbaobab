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
	/**
	 * вывод списка сотрудников
	 * @author 	Sasha
	 * @data 	21.08.2019
	 */
	public function actionEmployees()
	{
		$this->render('viewEmployees',array('employees'=>People::model()->findAll()));
	}
	/**
	 * вывод списка встреч
	 * @author 	Sasha
	 * @data 	21.08.2019
	 */
	public function actionMeeting()
	{
		$this->render('viewMeetings',array('meetings'=>Meets::model()->findAll()));
	}

	/**
	 * вывод формы добавления или само добавление сотрудника
	 * @author 	Sasha
	 * @data 	21.08.2019
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
	 * вывод формы добавления или само добавление встречи
	 * @author 	Sasha
	 * @data 	21.08.2019
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
	 * @param integer $id ключ сотрудника.
	 * @author 	Sasha
	 * @data 	21.08.2019
	 */
	public function actionDeleteEmployee($id)
	{
		People::model()->findByPk($id)->delete();
		$this->redirect($this->createUrl('site/employees'));
	}

	/**
	 * удаление встречи из базы
	 * @param integer $id ключ встречи.
	 * @author 	Sasha
	 * @data 	21.08.2019
	 */
	public function actionDeleteMeeting($id)
	{
		Meets::model()->findByPk($id)->delete();
		$this->redirect($this->createUrl('site/meeting'));
	}

	/**
	 * редактирование записи сотрудника
	 * @param integer $id ключ записи в БД
	 * @throws Exception
	 * @author 	Sasha
	 * @data 	21.08.2019
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
	 * @param integer $id ключ в таблице встреч
	 * @throws Exception
	 * @author 	Sasha
	 * @data 	21.08.2019
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
	 * viewCriteriaForm действие для страницы 'поиск больших встреч'
	 * @author 	Sasha
	 * @data 	21.08.2019
	 */
	public function actionCriteriaForm()
	{
		if(isset($_POST['criteria']))
		{
			$criteria=intval($_POST['criteria']);
			$meetingList = Meets::getAllByMemberCount($criteria);
			$this->render('viewCriteriaForm', array('meetingList' => $meetingList));
		}
		else
			$this->render('viewCriteriaForm', array());
	}

	/**
	 * позволяет выбрать комнату и выводит список событий в ней
	 * @param  string $id ключ комнаты базе
	 * @throws Exception
	 * @author 	Sasha
	 * @data 	21.08.2019
	 */
	public function actionRoomExplore($id)
	{
		if($id!='all' ) {
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
	 * удаляет комнату
	 * @param  integer $id ключ комнаты базе
	 * @throws Exception
	 * @author 	Sasha
	 * @data 	21.08.2019
	 */
	public function actionRoomDelete($id)
	{
		if(isset($id)) {
			$model = Room::model()->findByPk($id);
			if ($model) {
				$model->delete();
				$this->redirect($this->createUrl('roomExplore/all'));
			}
		}
		else
		{
			throw new Exception("error. room not found");
		}
	}
	/**
	 * добавление новой записи комнаты в базу
	 * @author 	Sasha
	 * @data 	21.08.2019
	 */
	public function actionInsertRoom()
	{
		$newrum = new Room();
		if (isset($_POST['ID'])) {
			$newrum->SaveAs();
			$this->redirect($this->createUrl('roomExplore/all'));
		} else {
			$this->render('viewRoomForm',
				[
					'model' => $newrum,
					'action' => 'insertRoom',
				]);
		}
	}
	/**
	 * редактирование записи комнаты
	 * @param integer $id ключ записи в БД
	 * @throws Exception
	 * @author 	Sasha
	 * @data 	21.08.2019
	 */
	public function actionEditRoom($id)
	{
		if(isset($_POST['ID']))
		{
			$newrum=Room::model()->findByPk(intval($_POST['ID']));
			if (!$newrum)
				throw new Exception("error. edit room id=$id not found");
			$newrum->SaveAs();
			$this->redirect($this->createUrl('roomExplore/all'));
		}
		else {
			$newrum=Room::model()->findByPk($id);
			$this->render('viewRoomForm',
				[
					'model' => $newrum,
					'action' => 'editRoom',
				]);
		}
	}
	/**
	 * позволяет выбрать отдел и выводит список сотрудников в нём
	 * @param  string $id ключ отдела в базе
	 * @throws Exception
	 * @author 	Sasha
	 * @data 	21.08.2019
	 */
	public function actionDeptExplore($id)
	{
		if($id!='all' ) {
			$model=Department::model()->findByPk($id);
			if (!$model)
				throw new Exception("error. department id=$id not found");
			$this->render('viewDepartmentTree',array('model'=>$model,));
		}
		else{
			$this->render('viewDepartmentList',array('items'=>Department::model()->findAll(),));
		}
	}

	/**
	 * удаляет отдел
	 * @param  integer $id ключ отдела базе
	 * @throws Exception
	 * @author 	Sasha
	 * @data 	21.08.2019
	 */
	public function actionDeptDelete($id)
	{
		if(isset($id)) {
			$model = Department::model()->findByPk($id);
			if ($model) {
				$model->delete();
				$this->redirect($this->createUrl('deptExplore/all'));
			}
		}
		else
		{
			throw new Exception("error. Department not found");
		}
	}


	/**
	 * добавление новой записи отдела в базу
	 * @author 	Sasha
	 * @data 	21.08.2019
	 */
	public function actionInsertDepartment()
	{
		$newdept = new Department();
		if (isset($_POST['ID'])) {
			$newdept->SaveAs();
			$this->redirect($this->createUrl('deptExplore/all'));
		} else {
			$this->render('viewDepartmentForm',
				[
					'model' => $newdept,
					'action' => 'insertDepartment',
				]);
		}
	}

	/**
	 * редактирование записи отдела
	 * @param integer $id ключ записи в БД
	 * @throws Exception
	 * @author 	Sasha
	 * @data 	21.08.2019
	 */
	public function actionEditDepartment($id)
	{
		if(isset($_POST['ID']))
		{
			$newdept=Department::model()->findByPk(intval($_POST['ID']));
			if (!$newdept)
				throw new Exception("error. edit Department id=$id not found");
			$newdept->SaveAs();
			$this->redirect($this->createUrl('deptExplore/all'));
		}
		else {
			$newdept=Department::model()->findByPk($id);
			$this->render('viewDepartmentForm',
				[
					'model' => $newdept,
					'action' => 'editDepartment',
				]);
		}
	}

}