<?php

use yii\db\Migration;

/**
 * Class m240324_212658_alter_table_client
 */
class m240324_212658_alter_table_client extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createIndex('{{%client_unique_cpf}}', '{{%client}}', 'cpf', true);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m240324_212658_alter_table_client cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m240324_212658_alter_table_client cannot be reverted.\n";

        return false;
    }
    */
}
