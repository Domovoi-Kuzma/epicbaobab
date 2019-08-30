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
    /**
     * Пропускает авторизующегося пользователя на сайт
     * @throws CException
     * @return boolean успешность идентификации
     */
    public  function authenticate()
    {
        $users=array(
            // username => password
            'admin'=>'admin',
        );
        $users=array(
            // username => password
            'admin'=>'admin',
        );
        if(!isset($users[$this->username]))
            $this->errorCode=self::ERROR_USERNAME_INVALID;
        elseif($users[$this->username]!==$this->password)
            $this->errorCode=self::ERROR_PASSWORD_INVALID;
        else
            $this->errorCode=self::ERROR_NONE;
        return $this->errorCode==self::ERROR_NONE;
    }

}
