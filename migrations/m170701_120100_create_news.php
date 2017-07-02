<?php

use yii\db\Migration;

class m170701_120100_create_news extends Migration
{
    public function safeUp()
    {

    }

    public function safeDown()
    {
        echo "m170701_120100_create_news cannot be reverted.\n";

        return false;
    }


    // Use up()/down() to run migration code without a transaction.
    public function up()
    {
        $this->createTable('news',[
            'id' => $this->primaryKey(),
            'title' => $this->string(),
            'preview' => $this->string(),
            'description' => $this->text(),
            'img' => $this->string(),
            'id_user' => $this->integer(),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer()
        ]);
    }

    public function down()
    {
        $this->dropTable('news');
    }

}
