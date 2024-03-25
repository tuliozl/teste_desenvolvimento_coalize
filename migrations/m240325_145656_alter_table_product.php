<?php

use yii\db\Migration;

/**
 * Class m240325_145656_alter_table_product
 */
class m240325_145656_alter_table_product extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addForeignKey('fk_product_client', 'product', 'client_id', 'client', 'id');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m240325_145656_alter_table_product cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m240325_145656_alter_table_product cannot be reverted.\n";

        return false;
    }
    */
}
