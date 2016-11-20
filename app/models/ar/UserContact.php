<?php

namespace app\models\ar;

use Yii;

/**
 * This is the model class for table "user_contact".
 *
 * @property integer $id
 * @property integer $user_id
 * @property string $type
 * @property string $name
 * @property string $value
 * @property integer $created_at
 * @property integer $updated_at
 *
 * @property User $user
 */
class UserContact extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'user_contact';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'type'], 'required'],
            [['user_id'], 'integer'],
            [['type'], 'string', 'max' => 32],
            [['name'], 'string', 'max' => 64],
            [['value'], 'string', 'max' => 255],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'type' => 'Type',
            'name' => 'Name',
            'value' => 'Value',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    public function behaviors()
    {
        return[
            \yii\behaviors\TimestampBehavior::className(),
        ];
    }
}
