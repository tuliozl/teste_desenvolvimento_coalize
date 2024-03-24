<?php

use yii\db\Migration;
use yii\db\Schema;

/**
 * Class m240322_211735_alter_table_user
 */
class m240322_211735_alter_table_user extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%user}}', 'access_token', Schema::TYPE_STRING."(255) NULL");
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m240322_211735_alter_table_user cannot be reverted.\n";

        $this->dropColumn('{{%user}}', 'access_token', Schema::TYPE_STRING."(255) NULL");

        return false;
    }

}
