<?php

use yii\db\Migration;

/**
 * Class m181224_143954_add_click_fields
 */
class m181224_143954_add_click_fields extends Migration
{
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {
        $this->addColumn('{{%static_page}}', 'clicks', $this->integer()->unsigned()->notNull()->defaultValue(0));
        $this->addColumn('{{%story}}', 'clicks', $this->integer()->unsigned()->notNull()->defaultValue(0));

        $this->createIndex('clicks', '{{%static_page}}', 'clicks');
        $this->createIndex('clicks', '{{%story}}', 'clicks');
    }

    public function down()
    {
        $this->dropColumn('{{%static_page}}', 'clicks');
        $this->dropColumn('{{%story}}', 'clicks');
    }
}
