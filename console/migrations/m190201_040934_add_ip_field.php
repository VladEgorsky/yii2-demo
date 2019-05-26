<?php

use yii\db\Migration;

/**
 * Class m190201_040934_add_ip_field
 */
class m190201_040934_add_ip_field extends Migration
{
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {
        $this->addColumn('{{%comment}}', 'ip', $this->integer()->unsigned()->notNull());
    }

    public function down()
    {
        $this->dropColumn('{{%comment}}', 'ip');
    }
}
