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

	/**
	 * действие "добавление сотрудника"
	 * по адресу index.php?r=site/insertEmployeeForm
	 * запрашиваем список встреч для рисования столбика чекбоксов и делаем форму.
	 */
	public function actionInsertEmployeeForm()
	{
		$model=new ModelInsertForm(' добавление сотрудника', 'employees');
		$model->QueryNames();
		$this->render('viewInsertForm',array('model'=>$model));
	}
	/**
	 * действие "добавление встречи"
	 * по адресу index.php?r=site/insertMeetingForm
	 * запрашиваем список сотрудников для рисования столбика чекбоксов и делаем форму.
	 */
	public function actionInsertMeetingForm()
	{
		$model=new ModelInsertForm(' добавление встречи', 'meets');
		$model->QueryNames();
		$this->render('viewInsertForm',array('model'=>$model));
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
		$this->redirect('index.php?r=site/employees');//после отправки формы уходим на какую-нибудь страницу
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
		$this->redirect('index.php?r=site/meeting');
	}

	/**
	 * действие "Список сотрудников" (пункт в меню) по адресу index.php?r=site/employees
	 * действие "Список встреч" (пункт в меню) по адресу index.php?r=site/meeting
	 * Вызывает модель списка, которая разбирается в составлении sql запросов.
	 */
	public function actionEmployees()
	{
		$model=new ModelList(' Список сотрудников', 'employees');
		$model->QueryNames();
		$this->render('viewList',array('model'=>$model));
	}
	public function actionMeeting()
	{
		$model=new ModelList(' Список встреч', 'meets');
		$model->QueryNames();
		$this->render('viewList',array('model'=>$model));
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