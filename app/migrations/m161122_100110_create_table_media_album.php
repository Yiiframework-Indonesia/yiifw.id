<?php

use yii\db\Schema;

class m161122_100110_create_table_media_album extends \yii\db\Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        }
        
        $this->createTable('media_album', [
            'id' => Schema::TYPE_PK,
            'category_id' => Schema::TYPE_INTEGER . '(11)',
            'title' => Schema::TYPE_STRING . '(255) NOT NULL',
            'slug' => Schema::TYPE_STRING . '(255)',
            'description' => Schema::TYPE_TEXT,
            'visible' => Schema::TYPE_INTEGER . '(11) NOT NULL DEFAULT 1',
            'created_at' => Schema::TYPE_INTEGER . '(11) NOT NULL',
            'updated_at' => Schema::TYPE_INTEGER . '(11)',
            'created_by' => Schema::TYPE_INTEGER . '(11)',
            'updated_by' => Schema::TYPE_INTEGER . '(11)',
            'FOREIGN KEY ([[category_id]]) REFERENCES media_category ([[id]]) ON DELETE CASCADE ON UPDATE CASCADE',
            'FOREIGN KEY ([[updated_by]]) REFERENCES user ([[id]]) ON DELETE CASCADE ON UPDATE CASCADE',
        ], $tableOptions);
    }

    public function down()
    {
        $this->dropTable('media_album');
    }
}
