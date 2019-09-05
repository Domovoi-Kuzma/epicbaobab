<?php
/**
 * Created by PhpStorm.
 * User: Sasha
 * Date: 30.08.2019
 * Time: 13:03
 */

/**
 * Class UserController
 * Работает по действиям, связанным с добавленным механизмом аккаунтов
 * @author  Sasha
 * @data    30.08.2019
 */
class UserController extends Controller
{
    private $_identity;

    /**
     * место для вызова панели админа
     * gazprom.loc/index.php?r=user/control
     * @author  Sasha
     * @date    30.08.2019
     */
    public function actionControl()
    {
        $users=User::model()->findAll();
        $this->render("globalAdminForm", ['users'=>$users]);
    }

    /**
     * Удаление аккаунта на сайте. Вызывается с миниформы админа.
     * @author  Sasha
     * @data    05.09.2019
     */
    public function actionAdminDelete()
    {
        $id=intval($_POST['ID']);
        $result = User::model()->deleteByPk($id);
        if ($result!=1)
            Yii::app()->user->setFlash('error', "Проверьте данные, 
            Ошибка удаления админом пользователя: 
            Удаление записи с ключом $id удалило $result записей");
         $this->redirect($this->createUrl('control'));
    }

    /**
     * Редактирование аккаунта на сайте. Вызывается с миниформы админа.
     * @author  Sasha
     * @data    05.09.2019
     */
    public function actionAdminEdit()
    {
        $id=intval($_POST['ID']);
        $record = User::model()->findByPk($id);
        if (is_null($record))
            Yii::app()->user->setFlash('error', "Проверьте данные, 
            Ошибка редактирования админом пользователя: Записи с ключом $id не найдено");
        if (!$record->saveAs())
            Yii::app()->user->setFlash('error', "Проверьте данные, 
            Ошибка редактирования админом пользователя: ".$record->getAllErrors());
        $this->redirect($this->createUrl('control'));
    }

    /**
     * Добавление 1 нового пользователя админом
     * @author Sasha
     * @date 05.09.2018
     */
    public function actionAdminInsert()
    {
        $newuser=new User();
        if(!$newuser->saveAs()) {
            Yii::app()->user->setFlash('error', "Проверьте данные, Ошибка сохранения ".$newuser->getAllErrors());
        }
        $this->redirect('control');
    }
    /**
     * на страницу входа пользователя
     * @author  Sasha
     * @date    30.08.2019
     */
    public function actionLogin()
    {
        if (isset($_POST['username'])) {
            $uname=$_POST['username'];
            $pass=$_POST['password'];
            //using Identity class
            if($this->_identity===null) {
                $this->_identity=new UserId($uname, $pass);
            }
            $this->_identity->authenticate();
            if ($this->_identity->errorCode==UserId::ERROR_NONE) {
                //$duration=$this->rememberMe ? 60 : 0;
                $duration = 60; // 1 minute
                Yii::app()->user->login($this->_identity, $duration);
                $this->redirect(Yii::app()->homeUrl);
            }
            else {
                Yii::app()->user->setFlash('error',"Ошибка идентификации ".$this->_identity->errorCode);
                $this->refresh();
            }
        }
        $this->render("loginForm");
    }

    /**
     * действие при разлогинивании - переход домой
     */
    public function actionLogout()
    {
        Yii::app()->user->logout();
        $this->redirect(Yii::app()->homeUrl);
    }
    public function filters()
    {
        return array(
            'accessControl', // perform access control for CRUD operations
        );
    }
    public function accessRules()
    {
        return array(
           array('allow',
                'actions' => array('Login'),
                'users'=>array('*'),
            ),
            array('allow',
                'actions' => array('control'),
                'users'=>array('admin'),
            ),
            array('deny',
                'actions' => array('control'),
                'users'=>array('*'),
            ),
        );
    }
}