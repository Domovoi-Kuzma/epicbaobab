<?php
/**
 * Created by PhpStorm.
 */
/**
 * Class SiteController
 *
 * мои actions это
 * actionInsertEmployeeForm - переход на страницу с формой добавления встр.
 * actionInsertMeetingForm	- переход на страницу с формой добавления сотр.
 * actionInsert_employees 	- отправка формы по добавлению сотр.
 * actionInsert_meets 		- отправка формы по добавлению встр.
 * actionEmployees  		- переход на страницу со списком сотр.
 * actionMeeting			- переход на страницу со списком встр.
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

	/*public function actionInsertEmployeeForm()
	{
		$model=new ModelShortList('employees');
		$model->QueryNames();
		$this->render('viewInsertForm',array('model'=>$model, 'what'=>'employees'));
	}*/
	/**
	 * действие "добавление встречи"
	 * по адресу index.php?r=site/insertMeetingForm
	 * запрашиваем список сотрудников для рисования столбика чекбоксов и делаем форму.
	 */
	public function actionInsertMeetingForm()
	{
		$model=new ModelShortList('meets');
		$model->QueryNames();
		$this->render('viewInsertForm',array('model'=>$model, 'what'=>'meets'));
	}
	/**
	 * действие "добавление сотрудника в БД"
	 * по Submiту формы
	 * Вызывает модель вставлятеля, который разбирается в составлении sql запросов.
	 */
	public function actionInsert_employees()
	{
		$model=new ModelInsert('employees');
		$model->ExecuteInsertion();
		$this->redirect($this->createUrl('site/employees') );//после отправки формы уходим на какую-нибудь страницу
	}
	/**
	 * действие "добавление встречи в БД"
	 * по Submiту формы
	 * Вызывает модель вставлятеля, который разбирается в составлении sql запросов.
	 */
	public function actionInsert_meets()
	{
		$model=new ModelInsert('meets');
		$model->ExecuteInsertion();
		$this->redirect($this->createUrl('site/meeting') );
	}

	/**
	 * действие "Список сотрудников" (пункт в меню) по адресу index.php?r=site/employees
	 * действие "Список встреч" (пункт в меню) по адресу index.php?r=site/meeting
	 * Вызывает модель списка, которая разбирается в составлении sql запросов.
	 */
	public function actionEmployees()
	{
		$this->render('viewEmployees',array());
	}
	public function actionMeeting()
	{
		$this->render('viewMeetings',array());
	}

	/**
	 *
	 */
	public function actionInsertEmployeeForm()
	{
		if(isset($_POST['NameInput']))
		{
			$newman=new People();
			$newman->saveAs($_POST['NameInput'], isset($_POST['options'])?$_POST['options']:[]);
			$this->redirect($this->createUrl('site/employees'));
		}
		else
		{
			$this->render('viewInsertEmployeeForm', array());
		}
	}
	/**
	 * действие "Редактирование сотрудника"  по адресу index.php?r=site/editEmployee
	 */
	public function actionEditEmployee($id)
	{
		$model=new ModelShortList('employees', $id);
		$model->QueryNames();
		$this->render('viewEdit',array('model'=>$model, 'what'=>'employees'));
	}
	/**
	 * действие "Сохранение сотрудника"  по нажатию кнопки формы редактора
	 */
	public function actionSaveEmployee()
	{

		$model=new ModelSave('employees');
		$model->ExecuteSaving();
		$this->redirect($this->createUrl('site/employees') );
	}
	/**
	 * действие "Редактирование сотрудника"  по адресу index.php?r=site/editEmployee
	 * @param $id int ID сотрудника в базе
	 */
	public function actionEditMeeting($id)
	{
		$model=new ModelShortList('meets', $id);
		$model->QueryNames();
		$this->render('viewEdit',array('model'=>$model, 'what'=>'meets'));
	}
	/**
	 * действие "Сохранение сотрудника"  по нажатию кнопки формы редактора
	 */
	public function actionSaveMeeting()
	{
		$model=new ModelSave('meets');
		$model->ExecuteSaving();
		$this->redirect($this->createUrl('site/meeting'));
	}

	/**
	 * Действие "Удаление сотрудника"
	 * по адресу index.php/site/delete/employee/id/7
	 * @param $id int ID сотрудника в базе
	 */
	public function actionDelete($what, $id)
	{
		$model=new ModelDelete($what);
		$model->Execute($id);

		if ($what == 'employees')
			$this->redirect($this->createUrl('site/employees'));
		else
			$this->redirect($this->createUrl('site/meeting'));
	}

	/**
	 * viewCriteriaForm действие  ' поиск больших встреч'
	 * переход по адресу index.php/site/viewCriteriaForm
	 */
	public function actionCriteriaForm()
	{
		$model=new ModelCriteria;
		//var_dump($_POST);
		if(isset($_POST['ModelCriteria'])) {
			$model->attributes = $_POST['ModelCriteria'];
			if ($model->validate()) {
				$model->QueryNames();
				$model->QueryBuddies();
				//print ('- results inside actionCriteriaForm<br>');
				//die();
				$this->render('viewCriteriaForm',array('model'=>$model));
				return;
			}
		}
		$this->render('viewCriteriaForm',array('model'=>$model));
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
				$name='=?UTF-8?B?'.base64_encode($model->name).'?=';
				$subject='=?UTF-8?B?'.base64_encode($model->subject).'?=';
				$headers="From: $name <{$model->email}>\r\n".
					"Reply-To: {$model->email}\r\n".
					"MIME-Version: 1.0\r\n".
					"Content-Type: text/plain; charset=UTF-8";

				mail(Yii::app()->params['adminEmail'],$subject,$model->body,$headers);
				Yii::app()->user->setFlash('contact','Thank you for contacting us. We will respond to you as soon as possible.');
				$this->refresh();
			}
		}
		$this->render('contact',array('model'=>$model));
	}

	/**
	 * Displays the login page
	 */
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
	}

	/**
	 * Logs out the current user and redirect to homepage.
	 */
	public function actionLogout()
	{
		Yii::app()->user->logout();
		$this->redirect(Yii::app()->homeUrl);
	}
}