<?php
/**
 * Created by PhpStorm.
 * User: Sasha
 * Date: 30.08.2019
 * Time: 14:07
 */

/**
 * Class UserId
 * предоставляет данные для проверки пароля юзера
 * для теста установлен аккаунт demo/demo
 * @todo изменить на идентификацию по базе
 * @todo подумать не здесь ли задать суперпользователя
 * @author  Sasha
 * @data    30.08.2019
 */
class UserId extends CUserIdentity
{
    private $_id;
    /**
     * Пропускает авторизующегося пользователя на сайт
     * @throws CException
     * @return boolean успешность идентификации
     */
 /*   public function authenticate()
    {
        $record=User::model()->findByAttributes(array('username'=>$this->username));
        if($record===null)
            $this->errorCode=self::ERROR_USERNAME_INVALID;
        else if(!CPasswordHelper::verifyPassword($this->password,$record->password))
            $this->errorCode=self::ERROR_PASSWORD_INVALID;
        else
        {
            $this->_id=$record->id;
            $this->setState('profile', $record->profile);
            $this->errorCode=self::ERROR_NONE;
        }
        return !$this->errorCode;
    }
    */
    public function authenticate()
    {
        if ($this->testSuperAccount())
            return !$this->errorCode;

        $user=User::model()->find('LOWER(username)=?',array(strtolower($this->username)));
        if($user==null) {
            $this->errorCode = self::ERROR_USERNAME_INVALID;
        }
        else if(!$user->validatePassword($this->password))
        {
            $this->errorCode = self::ERROR_PASSWORD_INVALID;
        }
        else
        {
            $this->_id=$user->ID;
            $this->setState('profile', $user->profile);
            $this->errorCode=self::ERROR_NONE;
        }
        return !$this->errorCode;
    }
    private function testSuperAccount()
    {
        if ($this->username=='admin'&& $this->password=='admin') {
            $this->errorCode=self::ERROR_NONE;
            $this->_id=1;
            $this->setState('profile', 'admin');
            return true;
        }
        return false;
    }
    /**
     * выдаёт
     * @return mixed
     */
    public function getId()
    {
        return $this->_id;
    }
}