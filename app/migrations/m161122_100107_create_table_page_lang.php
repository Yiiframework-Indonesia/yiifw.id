<?php

use yii\db\Schema;

class m161122_100107_create_table_page_lang extends \yii\db\Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        }
        
        $this->createTable('page_lang', [
            'id' => Schema::TYPE_PK,
            'page_id' => Schema::TYPE_INTEGER . '(11) NOT NULL',
            'language' => Schema::TYPE_STRING . '(6) NOT NULL',
            'title' => Schema::TYPE_TEXT . ' NOT NULL',
            'content' => Schema::TYPE_TEXT,
            'FOREIGN KEY ([[page_id]]) REFERENCES page ([[id]]) ON DELETE CASCADE ON UPDATE CASCADE',
        ], $tableOptions);
    }

    public function down()
    {
        $this->dropTable('page_lang');
    }
}
