<?php

use yii\db\Schema;

class m161203_170105_create_table_post_category extends \yii\db\Migration
{
    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        }
        
        $this->createTable('post_category', [
            'id' => $this->primaryKey(),
            'title' => $this->string(255)->notNull(),
            'slug' => $this->string(255)->notNull(),
            'description' => $this->string(255)->notNull(),
            'visible' => $this->integer(11)->notNull()->defaultValue(1),
            'created_at' => $this->integer(11)->notNull(),
            'updated_at' => $this->integer(11),
            'created_by' => $this->integer(11),
            'updated_by' => $this->integer(11),
            'lft' => $this->integer(11)->notNull(),
            'rgt' => $this->integer(11)->notNull(),
            'depth' => $this->integer(11)->notNull(),
            'FOREIGN KEY ([[updated_by]]) REFERENCES user ([[id]]) ON DELETE CASCADE ON UPDATE CASCADE',
        ], $tableOptions);
        
        
        $this->insert('post_category', [
            'title' => 'root',
            'slug' => 'root',
            'description' => 'root',
            'visible' => '0',
            'created_at' => '1455033000',
            'lft'=>'0',
            'rgt'=>'2147483647',
            'depth'=>'0'
        ]);
    }

    public function safeDown()
    {
        $this->delete('post_category', ['id' => 1]);
        $this->dropTable('post_category');
    }
}
