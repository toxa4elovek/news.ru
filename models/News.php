<?php

namespace app\models;

use yii\db\ActiveRecord;

/*
 * Модель для работы с новостями
 */
class News extends ActiveRecord
{
    public static function tableName()
    {
        return 'news';
    }
}