<?php

namespace accessUser\models;

use mdm\upload\FileModel;
use Yii;
use yii\helpers\Url;

/**
 * This is the model class for table "user_profile".
 *
 * @property integer $user_id
 * @property string $username
 * @property string $email
 * @property string $fullname
 * @property integer $photo_id
 * @property string $avatar
 * @property string $gender
 * @property string $address
 * @property string $birth_day
 * @property string $bio
 * @property integer $created_at
 * @property integer $updated_at
 * @property string $avatarUrl
 *
 * @property User $user
 * @property UserContact[] $contacts
 *
 */
class UserProfile extends \yii\db\ActiveRecord
{
    const MIN_AGE_ALLOWED = 15;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'user_profile';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'fullname'], 'required'],
            [['user_id'], 'integer'],
            [['birth_day'], 'safe'],
            [['birth_day'], 'date', 'format' => 'php:Y-m-d'],
            ['birth_day', 'minAge'],
            [['bio'], 'string'],
            [['file'], 'file', 'extensions' => ['jpg', 'jpeg', 'png']],
            [['fullname', 'avatar', 'gender', 'address'], 'string', 'max' => 255],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    public function minAge($attribute, $params)
    {
        if (!$this->hasErrors()) {
            $from = new \DateTime($this->birth_day);
            $to   = new \DateTime('today');

            if(self::MIN_AGE_ALLOWED >= $from->diff($to)->y){
                $this->addError($attribute, "Minimum age is ".self::MIN_AGE_ALLOWED);
            }
        }
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'user_id'    => 'User ID',
            'fullname'   => 'Fullname',
            'photo_id'   => 'Photo ID',
            'avatar'     => 'Avatar',
            'gender'     => 'Gender',
            'address'    => 'Address',
            'birth_day'  => 'Birth Day',
            'bio'        => 'Bio',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    public function afterSave($insert, $changedAttributes)
    {
        parent::afterSave($insert, $changedAttributes);
        if (!$insert && isset($changedAttributes['photo_id']) && ($model = FileModel::findOne($changedAttributes['photo_id'])) !== null) {
            $model->delete();
        }
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    /**
     * @return string
     */
    public function getAvatarUrl()
    {
        if ($this->photo_id) {
            return Url::to(['/image', 'id' => $this->photo_id], true);
        }
        return $this->avatar;
    }

    /**
     * @return string
     */
    public function getUsername()
    {
        return $this->user->username;
    }

    /**
     * @return string
     */
    public function getEmail()
    {
        return $this->user->email;
    }

    /**
     *
     * @return \yii\db\ActiveQuery
     */
    public function getContacts()
    {
        return $this->hasMany(UserContact::className(), ['user_id' => 'user_id']);
    }

    public function behaviors()
    {
        return [
            \yii\behaviors\TimestampBehavior::className(),
            [
                'class'          => 'mdm\upload\UploadBehavior',
                'savedAttribute' => 'photo_id',
            ],
        ];
    }
}
