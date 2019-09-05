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
 * @todo    добавить логин/логаут
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
     */
    public function actionControl()
    {
        $this->render("globalAdminForm");
    }

    public function actionAdminInsert()
    {
        $newuser=new User();
        $newuser->saveAs();
        $this->redirect('user/control');
    }
    /**
     * на страницу входа пользователя
     * @author  Sasha
     * @data    30.08.2019
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
            else{
                echo('<h1>YOU FAILED IT</h1>');
                var_dump($this->errorCode);
                die();
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