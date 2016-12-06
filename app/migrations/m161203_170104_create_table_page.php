<?php

use yii\db\Schema;

class m161203_170104_create_table_page extends \yii\db\Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        }
        
        $this->createTable('page', [
            'id' => $this->primaryKey(),
            'title' => $this->string(255)->notNull(),
            'content' => $this->text()->notNull(),
            'slug' => $this->string(255)->notNull()->defaultValue(''),
            'status' => $this->integer(1)->notNull()->defaultValue(0),
            'comment_status' => $this->integer(1)->notNull()->defaultValue(1),
            'published_at' => $this->integer(11),
            'created_by' => $this->integer(11),
            'created_at' => $this->integer(11)->notNull(),
            'updated_at' => $this->integer(11)->notNull(),
            'updated_by' => $this->integer(11),
            'revision' => $this->integer(11)->notNull()->defaultValue(1),
            'view' => $this->string(255)->notNull()->defaultValue('page'),
            'layout' => $this->string(255)->notNull()->defaultValue('main'),
            'FOREIGN KEY ([[updated_by]]) REFERENCES user ([[id]]) ON DELETE CASCADE ON UPDATE CASCADE',
        ], $tableOptions);
    }

    public function down()
    {
        $this->dropTable('page');
    }
}
