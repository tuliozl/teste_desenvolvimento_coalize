<?php

use yii\db\Schema;
use yii\db\Migration;

/**
 * Class m240323_194632_create_table_client
 */
class m240323_194632_create_table_client extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%client}}', [
            'id'            => Schema::TYPE_PK,
            'name'          => Schema::TYPE_STRING."(255) NOT NULL",
            'cpf'           => Schema::TYPE_STRING."(14) NOT NULL",
            'photo'         => Schema::TYPE_STRING."(255) NOT NULL",
            'address'       => Schema::TYPE_STRING."(255) NOT NULL",
            'number'        => Schema::TYPE_STRING."(50) NOT NULL",
            'complement'    => Schema::TYPE_STRING."(50) NULL",
            'district'      => Schema::TYPE_STRING."(50) NOT NULL",
            'city'          => Schema::TYPE_STRING."(50) NOT NULL",
            'state'         => Schema::TYPE_STRING."(50) NOT NULL",
            'zipcode'       => Schema::TYPE_STRING."(9) NOT NULL",
            'gender'        => "ENUM('F','M') NOT NULL",
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
        echo "m240323_194632_create_table_client cannot be reverted.\n";

        $this->dropTable('{{%client}}');

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m240323_194632_create_table_client cannot be reverted.\n";

        return false;
    }
    */
}
