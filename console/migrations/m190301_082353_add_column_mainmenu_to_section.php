<?php

use common\models\Section;
use yii\db\Migration;

/**
 * Class m190301_082353_add_column_mainmenu_to_section
 */
class m190301_082353_add_column_mainmenu_to_section extends Migration
{
    public function up()
    {
        $this->addColumn('{{%section}}', 'mainmenu', $this->boolean()->notNull()->defaultValue(true));
        $this->update('{{%section}}', ['mainmenu' => true]);
        $this->insert('{{%section}}', [
            'title' => 'Mainpage Upper Block',
            'pagetemplate_id' => Section::PAGE_TEMPLATE_UPPER_BLOCK,
            'mainmenu' => false,
        ]);
    }

    public function down()
    {
        $this->dropColumn('{{%section}}', 'mainmenu');
        $this->delete('{{%section}}', ['title' => 'Mainpage Upper Block']);
    }
}
