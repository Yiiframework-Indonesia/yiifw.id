<?php

use yii\db\Schema;

class m161203_170100_create_table_media_album extends \yii\db\Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        }
        
        $this->createTable('media_album', [
            'id' => $this->primaryKey(),
            'category_id' => $this->integer(11),
            'title' => $this->string(255)->notNull(),
            'slug' => $this->string(255),
            'description' => $this->text(),
            'visible' => $this->integer(11)->notNull()->defaultValue(1),
            'created_at' => $this->integer(11)->notNull(),
            'updated_at' => $this->integer(11),
            'created_by' => $this->integer(11),
            'updated_by' => $this->integer(11),
            'FOREIGN KEY ([[category_id]]) REFERENCES media_category ([[id]]) ON DELETE CASCADE ON UPDATE CASCADE',
            'FOREIGN KEY ([[updated_by]]) REFERENCES user ([[id]]) ON DELETE CASCADE ON UPDATE CASCADE',
        ], $tableOptions);
    }

    public function down()
    {
        $this->dropTable('media_album');
    }
}
