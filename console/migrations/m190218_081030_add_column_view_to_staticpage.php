<?php

use yii\db\Migration;

/**
 * Class m190218_081030_add_column_view_to_staticpage
 */
class m190218_081030_add_column_view_to_staticpage extends Migration
{
    public function up()
    {
        $this->addColumn('{{%static_page}}', 'view', $this->string()->notNull());
        $this->update('{{%static_page}}', ['view' => 'about'], ['title' => 'About us']);
        $this->update('{{%static_page}}', ['view' => 'terms'], ['title' => 'Terms & conditions']);
        $this->update('{{%static_page}}', ['view' => 'policy'], ['title' => 'Privacy policy']);
    }

    public function down()
    {
        $this->dropColumn('{{%static_page}}', 'view');
    }
}
