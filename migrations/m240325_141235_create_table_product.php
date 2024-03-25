<?php

use yii\db\Migration;
use yii\db\Schema;

/**
 * Class m240325_141235_create_table_product
 */
class m240325_141235_create_table_product extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%product}}', [
            'id'            => Schema::TYPE_PK,
            'client_id'     => Schema::TYPE_INTEGER." NOT NULL",
            'name'          => Schema::TYPE_STRING."(255) NOT NULL",
            'photo'         => Schema::TYPE_STRING."(255) NOT NULL",
            'price'         => Schema::TYPE_FLOAT." NOT NULL",
            'created_at'    => Schema::TYPE_DATETIME." NOT NULL DEFAULT NOW()",
            'last_edit_at'  => Schema::TYPE_DATETIME." NOT NULL DEFAULT NOW()",
            'deleted_at'    => Schema::TYPE_DATETIME." NULL",
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m240325_141235_create_table_product cannot be reverted.\n";

        $this->dropTable('{{%product}}');

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m240325_141235_create_table_product cannot be reverted.\n";

        return false;
    }
    */
}
