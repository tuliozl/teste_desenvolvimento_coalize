<?php

use yii\db\Schema;
use yii\db\Migration;

/**
 * Class m240321_191115_create_table_user
 */
class m240321_191115_create_table_user extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%user}}', [
            'id'                   => Schema::TYPE_PK,
            'username'             => Schema::TYPE_STRING."(25) NOT NULL",
            'firstname'            => Schema::TYPE_STRING."(255) NOT NULL",
            'password'        => Schema::TYPE_STRING."(255) NOT NULL",
        ]);

        $this->createIndex('{{%user_unique_username}}', '{{%user}}', 'username', true);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m240321_191115_create_table_user cannot be reverted.\n";

        $this->dropTable('{{%user}}');

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m240321_191115_create_table_user cannot be reverted.\n";

        return false;
    }
    */
}
