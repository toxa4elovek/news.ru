<?php
namespace mdm\admin\models\form;

use Yii;
use mdm\admin\models\User;
use yii\base\Model;

/**
 * Signup form
 */
class Signup extends Model
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
            ['username', 'unique', 'targetClass' => 'mdm\admin\models\User', 'message' => 'Такое имя уже зарегистрировано'],
            ['username', 'string', 'min' => 2, 'max' => 255],

            ['email', 'filter', 'filter' => 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'unique', 'targetClass' => 'mdm\admin\models\User', 'message' => 'Такой email уже зарегистрирован'],

            ['password', 'required'],
            ['password', 'string', 'min' => 6],

            ['status', 'default', 'value' => User::STATUS_ACTIVE],
            ['status', 'in', 'range' => [User::STATUS_ACTIVE, User::STATUS_INACTIVE]],
            ['status', 'default', 'value' => User::STATUS_INACTIVE, 'on' => 'emailActivation'],
        ];
    }


    public function attributeLabels()
    {
        return [
            'username' => 'Имя',
            'email' => 'Email',
            'password' => 'Пароль'
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
            ->setFrom([Yii::$app->params['supportEmail'] => 'Отправлено служюой поддержки'])
            ->setTo($this->email)
            ->setSubject('Активация для '.Yii::$app->name)
            ->send();
    }
}
