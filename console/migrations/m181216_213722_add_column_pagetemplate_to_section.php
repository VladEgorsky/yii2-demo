<?php

use yii\db\Migration;

/**
 * Class m181216_213722_add_column_pagetemplate_to_section
 */
class m181216_213722_add_column_pagetemplate_to_section extends Migration
{
    public function up()
    {
        $this->addColumn('{{%section}}', 'pagetemplate_id', $this->tinyInteger()->unsigned()->notNull()->defaultValue(0));
    }

    public function down()
    {
        $this->dropColumn('{{%section}}', 'pagetemplate_id');
    }
}
