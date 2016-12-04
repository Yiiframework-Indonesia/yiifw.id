<?php

use yii\db\Schema;

class m161203_170106_create_table_post extends \yii\db\Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        }
        
        $this->createTable('post', [
            'id' => $this->primaryKey(),
            'title' => $this->string(255)->notNull(),
            'content' => $this->text()->notNull(),
            'slug' => $this->string(255)->notNull()->defaultValue(''),
            'category_id' => $this->integer(11),
            'status' => $this->integer(1)->notNull()->defaultValue(0),
            'comment_status' => $this->integer(1)->notNull()->defaultValue(1),
            'thumbnail' => $this->string(255),
            'published_at' => $this->integer(11),
            'created_at' => $this->integer(11)->notNull(),
            'updated_at' => $this->integer(11),
            'created_by' => $this->integer(11),
            'updated_by' => $this->integer(11),
            'revision' => $this->integer(11)->notNull()->defaultValue(1),
            'view' => $this->string(255)->notNull()->defaultValue('post'),
            'layout' => $this->string(255)->notNull()->defaultValue('main'),
            'FOREIGN KEY ([[category_id]]) REFERENCES post_category ([[id]]) ON DELETE CASCADE ON UPDATE CASCADE',
            'FOREIGN KEY ([[updated_by]]) REFERENCES user ([[id]]) ON DELETE CASCADE ON UPDATE CASCADE',
        ], $tableOptions);
    }

    public function down()
    {
        $this->dropTable('post');
    }
}
