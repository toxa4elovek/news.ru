<?php

use yii\helpers\Html;

echo 'Зарегистрирован новый пользователь '.Html::encode($user->username).'. ';

echo 'Письмо с активацией отправлено на адрес '. Html::encode($user->email).'.';