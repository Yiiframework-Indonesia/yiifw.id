<?php

use yii\db\Schema;

class m161122_100111_create_table_media extends \yii\db\Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        }
        
        $this->createTable('media', [
            'id' => Schema::TYPE_PK,
            'album_id' => Schema::TYPE_INTEGER . '(11)',
            'filename' => Schema::TYPE_STRING . '(255) NOT NULL',
            'type' => Schema::TYPE_STRING . '(255) NOT NULL',
            'url' => Schema::TYPE_TEXT . ' NOT NULL',
            'size' => Schema::TYPE_STRING . '(255) NOT NULL',
            'thumbs' => Schema::TYPE_TEXT,
            'created_at' => Schema::TYPE_INTEGER . '(11) NOT NULL',
            'updated_at' => Schema::TYPE_INTEGER . '(11)',
            'created_by' => Schema::TYPE_INTEGER . '(11)',
            'updated_by' => Schema::TYPE_INTEGER . '(11)',
            'FOREIGN KEY ([[album_id]]) REFERENCES media_album ([[id]]) ON DELETE CASCADE ON UPDATE CASCADE',
            'FOREIGN KEY ([[updated_by]]) REFERENCES user ([[id]]) ON DELETE CASCADE ON UPDATE CASCADE',
        ], $tableOptions);
    }

    public function down()
    {
        $this->dropTable('media');
    }
}
