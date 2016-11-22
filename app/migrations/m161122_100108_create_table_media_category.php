<?php

use yii\db\Schema;

class m161122_100108_create_table_media_category extends \yii\db\Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        }
        
        $this->createTable('media_category', [
            'id' => Schema::TYPE_PK,
            'slug' => Schema::TYPE_STRING . '(255)',
            'title' => Schema::TYPE_STRING . '(255) NOT NULL',
            'description' => Schema::TYPE_TEXT,
            'visible' => Schema::TYPE_INTEGER . '(11) NOT NULL DEFAULT 1',
            'created_at' => Schema::TYPE_INTEGER . '(11) NOT NULL',
            'updated_at' => Schema::TYPE_INTEGER . '(11)',
            'created_by' => Schema::TYPE_INTEGER . '(11)',
            'updated_by' => Schema::TYPE_INTEGER . '(11)',
            'FOREIGN KEY ([[updated_by]]) REFERENCES user ([[id]]) ON DELETE CASCADE ON UPDATE CASCADE',
        ], $tableOptions);
    }

    public function down()
    {
        $this->dropTable('media_category');
    }
}
