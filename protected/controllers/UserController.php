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
    /**
     * на страницу входа пользователя
     */
    private $_identity;
    public function actionLogin()
    {
        if (isset($_POST['username'])) {
            $uname=$_POST['username'];
            $pass=$_POST['password'];

            //m>login was here in examle

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
}