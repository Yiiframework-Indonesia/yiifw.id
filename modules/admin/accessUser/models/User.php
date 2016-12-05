<?php

namespace accessUser\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;

/**
 * User model
 *
 * @property integer $id
 * @property string $username
 * @property string $password_hash
 * @property string $password_reset_token
 * @property string $email
 * @property string $auth_key
 * @property integer $status
 * @property integer $created_at
 * @property integer $updated_at
 * @property string $password write-only password
 *
 * @property UserProfile $profile
 * @property UserContact[] $contacts
 */
class User extends ActiveRecord implements IdentityInterface
{
    const STATUS_PANDING    = 0;
    const STATUS_ACTIVE     = 10;
    const STATUS_DELETED    = 20;
    const SCENARIO_INIT_CMD = 'init_via_command';

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'user';
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['status', 'default', 'value' => YII_DEBUG ? self::STATUS_ACTIVE : self::STATUS_PANDING],
            ['status', 'in', 'range' => [self::STATUS_PANDING, self::STATUS_ACTIVE, self::STATUS_DELETED]],
            ['username', 'unique', 'on' => self::SCENARIO_INIT_CMD],
            ['email', 'unique', 'on' => self::SCENARIO_INIT_CMD],
        ];
    }

    /**
     * @inheritdoc
     */
    public static function findIdentity($id)
    {
        return static::findOne(['id' => $id, 'status' => self::STATUS_ACTIVE]);
    }

    /**
     * @inheritdoc
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        if (($id = Yii::$app->tokenManager->getTokenData($token, 'login.credential')) !== false) {
            return static::findOne(['id' => $id, 'status' => self::STATUS_ACTIVE]);
        }
    }

    /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */
    public static function findByUsername($username)
    {
        return static::find()
            ->where(['status' => self::STATUS_ACTIVE])
            ->andWhere(['OR', ['username' => $username], ['email' => $username]])
            ->one();
    }

    /**
     * Finds user by password reset token
     *
     * @param string $token password reset token
     * @return static|null
     */
    public static function findByPasswordResetToken($token)
    {
        if (($id = Yii::$app->tokenManager->getTokenData($token, 'reset.password')) !== false) {
            return static::findOne(['id' => $id, 'status' => self::STATUS_ACTIVE]);
        }
    }

    public static function getUniqueUsername($username)
    {
        $i    = 1;
        $name = $username;
        while (static::find()->where(['username' => $name])->exists()) {
            $name = $username . $i++;
        }
        return $name;
    }

    /**
     * @inheritdoc
     */
    public function getId()
    {
        return $this->getPrimaryKey();
    }

    /**
     * @inheritdoc
     */
    public function getAuthKey()
    {
        return $this->auth_key;
    }

    /**
     * @inheritdoc
     */
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return boolean if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return Yii::$app->security->validatePassword($password, $this->password_hash);
    }

    /**
     * Generates password hash from password and sets it to the model
     *
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->password_hash = Yii::$app->security->generatePasswordHash($password);
    }

    /**
     * Generates "remember me" authentication key
     */
    public function generateAuthKey()
    {
        $this->auth_key = Yii::$app->security->generateRandomString();
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProfile()
    {
        return $this->hasOne(UserProfile::className(), ['user_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getContacts()
    {
        return $this->hasMany(UserContact::className(), ['user_id' => 'id']);
    }

    public static function getStatusView($code = null)
    {
        $_items = [
            self::STATUS_PANDING => 'Inactive',
            self::STATUS_ACTIVE   => 'Active',
            self::STATUS_DELETED   => 'Banned',
        ];
        if (isset($code)) {
            return isset($_items[$code]) ? $_items[$code] : false;
        } else {
            return isset($_items) ? $_items : false;
        }

    }
}
