<?php

use yii\db\Migration;

/**
 * Class m181213_185326_add_clicks_field
 */
class m181213_185326_add_clicks_field extends Migration
{
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {
        $this->addColumn('{{%news}}', 'clicks', $this->integer()->unsigned()->notNull()->defaultValue(0));
        $this->addColumn('{{%advertise}}', 'clicks', $this->integer()->unsigned()->notNull()->defaultValue(0));

        $this->createIndex('clicks', '{{%news}}', 'clicks');
        $this->createIndex('clicks', '{{%advertise}}', 'clicks');
    }

    public function down()
    {
        $this->dropIndex('clicks', '{{%news}}');
        $this->dropIndex('clicks', '{{%advertise}}');

        $this->dropColumn('{{%news}}', 'clicks');
        $this->dropColumn('{{%advertise}}', 'clicks');
    }
}
