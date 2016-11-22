<?php

use yii\db\Schema;

class m161122_100101_create_table_post extends \yii\db\Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        }
        
        $this->createTable('post', [
            'id' => Schema::TYPE_PK,
            'slug' => Schema::TYPE_STRING . "(127) NOT NULL DEFAULT ''",
            'category_id' => Schema::TYPE_INTEGER . '(11)',
            'status' => Schema::TYPE_INTEGER . '(1) NOT NULL DEFAULT 0',
            'comment_status' => Schema::TYPE_INTEGER . '(1) NOT NULL DEFAULT 1',
            'thumbnail' => Schema::TYPE_STRING . '(255)',
            'published_at' => Schema::TYPE_INTEGER . '(11)',
            'created_at' => Schema::TYPE_INTEGER . '(11) NOT NULL',
            'updated_at' => Schema::TYPE_INTEGER . '(11)',
            'created_by' => Schema::TYPE_INTEGER . '(11)',
            'updated_by' => Schema::TYPE_INTEGER . '(11)',
            'revision' => Schema::TYPE_INTEGER . '(11) NOT NULL DEFAULT 1',
            'view' => Schema::TYPE_STRING . "(255) NOT NULL DEFAULT 'post'",
            'layout' => Schema::TYPE_STRING . "(255) NOT NULL DEFAULT 'main'",
            'FOREIGN KEY ([[category_id]]) REFERENCES post_category ([[id]]) ON DELETE CASCADE ON UPDATE CASCADE',
            'FOREIGN KEY ([[updated_by]]) REFERENCES user ([[id]]) ON DELETE CASCADE ON UPDATE CASCADE',
        ], $tableOptions);
    }

    public function down()
    {
        $this->dropTable('post');
    }
}
