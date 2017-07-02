<?php

namespace app\models;

use yii\base\InvalidParamException;
use yii\base\Model;
use Yii;

class AccountActivation extends Model
{
    private $_user;

    public function __construct($key, array $config = [])
    {
        if(empty($key) || !is_string($key))
            throw new InvalidParamException('Ключ не может быть пустым');
        $this->_user = User::findBySecretKey($key);
        if(!$this->_user)
            throw new InvalidParamException('Не верный ключ');
        parent::__construct($config);
    }

    public function activateAccount()
    {
        $user = $this->_user;
        $user->status = User::STATUS_ACTIVE;
        $user->removeSecretKey();
        $this->setRole();
        $this->login();
        return $user->save();
    }

    public function getUsername()
    {
        $user = $this->_user;
        return $user->username;
    }

    public function login()
    {
        return Yii::$app->getUser()->login($this->getUser(),  3600 * 24 * 30 );
    }

    public function getUser()
    {
        return User::findOne(['username' => $this->getUsername()]);

    }

    public function setRole()
    {
        $userRole = Yii::$app->authManager->getRole('User');
        Yii::$app->authManager->assign($userRole,$this->_user->id);
    }

}
