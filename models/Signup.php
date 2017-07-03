<?php
namespace app\models;

use Swift_Plugins_Loggers_ArrayLogger;
use Swift_Plugins_LoggerPlugin;

use mdm\admin\models\form\Signup as SignupForm;
use Yii;

/*
 * Модель формы регистрации
 */
class Signup extends SignupForm
{
    public $username;
    public $email;
    public $password;
    public $status;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['username', 'filter', 'filter' => 'trim'],
            ['username', 'required'],
            //['username', 'unique', 'targetClass' => 'mdm\admin\models\User', 'message' => 'This username has already been taken.'],
            ['username', 'string', 'min' => 2, 'max' => 255],

            ['email', 'filter', 'filter' => 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            //['email', 'unique', 'targetClass' => 'mdm\admin\models\User', 'message' => 'This email address has already been taken.'],

            ['password', 'required'],
            ['password', 'string', 'min' => 6],

            ['status', 'default', 'value' => User::STATUS_INACTIVE],
            ['status', 'in', 'range' => [User::STATUS_ACTIVE, User::STATUS_INACTIVE]],
            ['status', 'default', 'value' => User::STATUS_INACTIVE, 'on' => 'emailActivation'],
        ];
    }

    /**
     * Signs user up.
     *
     * @return User|null the saved model or null if saving fails
     */
    public function signup()
    {
        if ($this->validate()) {
            $user = new User();
            $user->username = $this->username;
            $user->email = $this->email;
            $user->setPassword($this->password);
            $user->status = $this->status;
            $user->generateAuthKey();
            if($this->scenario === 'emailActivation')
                $user->generateSecretKey();
            if ($user->save()) {
                return $user;
            }
        }

        return null;
    }

    public function sendActivationEmail($user)
    {
           return Yii::$app->mailer->compose('activationEmail',['user' => $user])
            ->setFrom([Yii::$app->params['supportEmail'] => 'Отправлено службой поддержки'])
            ->setTo($this->email)
            ->setSubject('Активация для '.Yii::$app->name)
            ->send();
    }

    public function sendAdminEmail($user)
    {
        return Yii::$app->mailer->compose('adminEmail',['user' => $user])
            ->setFrom([Yii::$app->params['supportEmail'] => 'Уведомление о регистрации'])
            ->setTo(Yii::$app->params['adminEmail'])
            ->setSubject('Регистрация новго пользователя'.Yii::$app->name)
            ->send();
    }
}