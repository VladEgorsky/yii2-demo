<?php

use yii\db\Migration;

/**
 * Class m190124_155939_add_image_field
 */
class m190124_155939_add_image_field extends Migration
{
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {
        $this->addColumn('{{%advertise}}', 'image', $this->string()->null()->after('content'));
        $this->addColumn('{{%advertise}}', 'location_id',
            $this->smallInteger()->notNull()->after('email')->defaultValue(0));
    }

    public function down()
    {
        $this->dropColumn('{{%advertise}}', 'image');
        $this->dropColumn('{{%advertise}}', 'location_id');
    }
}
