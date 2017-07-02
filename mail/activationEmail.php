<?php
/**
 * Created by PhpStorm.
 * User: Антон
 * Date: 01.07.2017
 * Time: 20:49
 * @var $this yii\web\View
 * @var $user app\models\User
 */

use yii\helpers\Html;

echo 'Привет '.Html::encode($user->username).'. ';
echo Html::a('Для активации аккаунта перейдите по этой ссылке. ',
    Yii::$app->urlManager->createAbsoluteUrl(
        [
            'site/activate-account',
            'key' => $user->secret_key
        ])
);