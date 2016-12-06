<?php

use yii\db\Schema;

class m161203_170101_create_table_media extends \yii\db\Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        }
        
        $this->createTable('media', [
            'id' => $this->primaryKey(),
            'album_id' => $this->integer(11),
            'filename' => $this->string(255)->notNull(),
            'type' => $this->string(255)->notNull(),
            'url' => $this->text()->notNull(),
            'size' => $this->string(255)->notNull(),
            'thumbs' => $this->text(),
            'created_at' => $this->integer(11)->notNull(),
            'updated_at' => $this->integer(11),
            'created_by' => $this->integer(11),
            'updated_by' => $this->integer(11),
            'FOREIGN KEY ([[album_id]]) REFERENCES media_album ([[id]]) ON DELETE CASCADE ON UPDATE CASCADE',
            'FOREIGN KEY ([[updated_by]]) REFERENCES user ([[id]]) ON DELETE CASCADE ON UPDATE CASCADE',
        ], $tableOptions);
    }

    public function down()
    {
        $this->dropTable('media');
    }
}
