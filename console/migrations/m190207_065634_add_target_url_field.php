<?php

use yii\db\Migration;

/**
 * Class m190207_065634_add_target_url_field
 */
class m190207_065634_add_target_url_field extends Migration
{
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {
        $this->addColumn('{{%advertise}}', 'target_url', $this->string()->null());
    }

    public function down()
    {
        $this->dropColumn('{{%advertise}}', 'target_url');
    }
}
