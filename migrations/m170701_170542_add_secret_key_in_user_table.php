<?php

use yii\db\Migration;
use yii\db\Schema;

class m170701_170542_add_secret_key_in_user_table extends Migration
{
    public function safeUp()
    {

    }

    public function safeDown()
    {
        echo "m170701_170542_add_secret_key_in_user_table cannot be reverted.\n";

        return false;
    }


    // Use up()/down() to run migration code without a transaction.
    public function up()
    {
        $this->addColumn('user', 'secret_key', Schema::TYPE_STRING);
    }

    public function down()
    {
        $this->dropColumn('user', 'secret_key');
    }

}
