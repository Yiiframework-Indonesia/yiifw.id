<?php

use yii\db\Schema;

class m161122_100105_create_table_page extends \yii\db\Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        }
        
        $this->createTable('page', [
            'id' => Schema::TYPE_PK,
            'slug' => Schema::TYPE_STRING . "(200) NOT NULL DEFAULT ''",
            'status' => Schema::TYPE_INTEGER . '(1) NOT NULL DEFAULT 0',
            'comment_status' => Schema::TYPE_INTEGER . '(1) NOT NULL DEFAULT 1',
            'published_at' => Schema::TYPE_INTEGER . '(11)',
            'created_by' => Schema::TYPE_INTEGER . '(11)',
            'created_at' => Schema::TYPE_INTEGER . '(11) NOT NULL',
            'updated_at' => Schema::TYPE_INTEGER . '(11) NOT NULL',
            'updated_by' => Schema::TYPE_INTEGER . '(11)',
            'revision' => Schema::TYPE_INTEGER . '(11) NOT NULL DEFAULT 1',
            'view' => Schema::TYPE_STRING . "(255) NOT NULL DEFAULT 'page'",
            'layout' => Schema::TYPE_STRING . "(255) NOT NULL DEFAULT 'main'",
            'FOREIGN KEY ([[updated_by]]) REFERENCES user ([[id]]) ON DELETE CASCADE ON UPDATE CASCADE',
        ], $tableOptions);
    }

    public function down()
    {
        $this->dropTable('page');
    }
}
