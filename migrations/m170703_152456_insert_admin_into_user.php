<?php

use yii\db\Migration;

class m170703_152456_insert_admin_into_user extends Migration
{
    public function safeUp()
    {

    }

    public function safeDown()
    {
        echo "m170703_152456_insert_admin_into_user cannot be reverted.\n";

        return false;
    }


    // Use up()/down() to run migration code without a transaction.
    public function up()
    {
        $this->insert('user', [
            'username' => 'admin',
            'auth_key' =>Yii::$app->security->generateRandomString(),
            'password_hash' => Yii::$app->security->generatePasswordHash('123321'),
            'email' => Yii::$app->params['adminEmail'],
            'status' => \app\models\User::STATUS_ACTIVE,
            'created_at' => time(),
            'updated_at' => time(),
            'secret_key' => null
        ]);
    }

    public function down()
    {
        echo "m170703_152456_insert_admin_into_user cannot be reverted.\n";

        return false;
    }

}
