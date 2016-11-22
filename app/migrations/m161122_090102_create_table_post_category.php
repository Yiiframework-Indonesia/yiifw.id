<?php

use yii\db\Schema;

class m161122_090102_create_table_post_category extends \yii\db\Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        }
        
        $this->createTable('post_category', [
            'id' => Schema::TYPE_PK,
            'slug' => Schema::TYPE_STRING . '(255)',
            'visible' => Schema::TYPE_INTEGER . '(11) NOT NULL DEFAULT 1',
            'created_at' => Schema::TYPE_INTEGER . '(11) NOT NULL',
            'updated_at' => Schema::TYPE_INTEGER . '(11)',
            'created_by' => Schema::TYPE_INTEGER . '(11)',
            'updated_by' => Schema::TYPE_INTEGER . '(11)',
            'left_border' => Schema::TYPE_INTEGER . '(11) NOT NULL',
            'right_border' => Schema::TYPE_INTEGER . '(11) NOT NULL',
            'depth' => Schema::TYPE_INTEGER . '(11) NOT NULL',
            'FOREIGN KEY ([[updated_by]]) REFERENCES user ([[id]]) ON DELETE CASCADE ON UPDATE CASCADE',
        ], $tableOptions);
    }

    public function down()
    {
        $this->dropTable('post_category');
    }
}
