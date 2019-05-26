<?php

use yii\db\Migration;

/**
 * Class m181224_080024_create_advertise_tag_and_section_tables
 */
class m181224_080024_create_advertise_tag_and_section_tables extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%advertise_section}}', [
            'section_id' => $this->integer()->notNull(),
            'advertise_id' => $this->integer()->notNull(),
        ]);

        $this->createTable('{{%advertise_tag}}', [
            'tag_id' => $this->integer()->notNull(),
            'advertise_id' => $this->integer()->notNull(),
        ]);

        $this->createIndex('idx_advertise_section', 'advertise_section', ['section_id', 'advertise_id'], true);
        $this->createIndex('idx_advertise_tag', 'advertise_tag', ['tag_id', 'advertise_id'], true);

        $this->addForeignKey('fk_advertise_section_to_section', '{{%advertise_section}}', 'section_id', '{{%section}}', 'id', 'CASCADE');
        $this->addForeignKey('fk_advertise_section_to_advertise', '{{%advertise_section}}', 'advertise_id', '{{%advertise}}', 'id', 'CASCADE');

        $this->addForeignKey('fk_advertise_tag_to_tag', '{{%advertise_tag}}', 'tag_id', '{{%tag}}', 'id', 'CASCADE');
        $this->addForeignKey('fk_advertise_tag_to_advertise', '{{%advertise_tag}}', 'advertise_id', '{{%advertise}}', 'id', 'CASCADE');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk_advertise_section_to_section', '{{%advertise_section}}');
        $this->dropForeignKey('fk_advertise_section_to_advertise', '{{%advertise_section}}');
        $this->dropForeignKey('fk_advertise_tag_to_tag', '{{%advertise_tag}}');
        $this->dropForeignKey('fk_advertise_tag_to_advertise', '{{%advertise_tag}}');

        $this->dropTable('{{%advertise_tag}}');
        $this->dropTable('{{%advertise_section}}');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m181224_080024_create_advertise_tag_and_section_tables cannot be reverted.\n";

        return false;
    }
    */
}
