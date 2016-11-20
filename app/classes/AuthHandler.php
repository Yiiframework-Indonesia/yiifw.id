<?php

namespace app\classes;

use Yii;
use app\models\ar\Auth;
use app\models\ar\User;
use app\models\ar\UserProfile;
use app\models\ar\UserContact;
use yii\authclient\ClientInterface;
use yii\helpers\ArrayHelper;

/**
 * Description of AuthHandler
 *
 * @author Misbahul D Munir <misbahuldmunir@gmail.com>
 * @since 1.0
 */
class AuthHandler
{
    /**
     * @var ClientInterface
     */
    protected $client;

    public function __construct(ClientInterface $client)
    {
        $this->client = $client;
    }

    public function handle()
    {
        $attributes = $this->client->getUserAttributes();
        $email = ArrayHelper::getValue($attributes, 'email');
        $id = ArrayHelper::getValue($attributes, 'id');
        $username = isset($attributes['nickname']) ? $attributes['nickname'] : explode('@', $email)[0];
        if (in_array($username, ['admin', 'administrator', 'superadmin', 'super', 'root'])) {
            $username = 'no_' . $username;
        }
        $username = User::getUniqueUsername($username);
        /* @var Auth $auth */
        $auth = Auth::find()->where([
                'source' => $this->client->getId(),
                'source_id' => $id,
            ])->one();

        if (Yii::$app->user->isGuest) {
            if ($auth) { // login
                /* @var $user User */
                $user = $auth->user;
                $this->updateUserInfo($user);
                Yii::$app->user->login($user, Yii::$app->params['user.rememberMeDuration']);
            } else { // signup
                if ($email !== null && User::find()->where(['email' => $email])->exists()) {
                    Yii::$app->getSession()->setFlash('error', [
                        Yii::t('app', "User with the same email as in {client} account already exists but isn't linked to it. Login using email first to link it.", ['client' => $this->client->getTitle()]),
                    ]);
                } else {
                    $password = Yii::$app->security->generateRandomString(6);
                    $user = new User([
                        'username' => $username,
                        'email' => $email,
                        'password' => $password,
                        'status' => User::STATUS_ACTIVE,
                    ]);
                    $user->generateAuthKey();

                    $transaction = User::getDb()->beginTransaction();

                    if ($user->save()) {
                        $this->updateUserInfo($user);
                        $auth = new Auth([
                            'user_id' => $user->id,
                            'source' => $this->client->getId(),
                            'source_id' => (string) $id,
                        ]);
                        if ($auth->save()) {
                            $transaction->commit();
                            Yii::$app->user->login($user, Yii::$app->params['user.rememberMeDuration']);
                        } else {
                            Yii::$app->getSession()->setFlash('error', [
                                Yii::t('app', 'Unable to save {client} account: {errors}', [
                                    'client' => $this->client->getTitle(),
                                    'errors' => json_encode($auth->getErrors()),
                                ]),
                            ]);
                        }
                    } else {
                        Yii::$app->getSession()->setFlash('error', [
                            Yii::t('app', 'Unable to save user: {errors}', [
                                'client' => $this->client->getTitle(),
                                'errors' => json_encode($user->getErrors()),
                            ]),
                        ]);
                    }
                }
            }
        } else { // user already logged in
            if (!$auth) { // add auth provider
                $auth = new Auth([
                    'user_id' => Yii::$app->user->id,
                    'source' => $this->client->getId(),
                    'source_id' => (string) $attributes['id'],
                ]);
                if ($auth->save()) {
                    /** @var User $user */
                    $user = $auth->user;
                    $this->updateUserInfo($user);
                    Yii::$app->getSession()->setFlash('success', [
                        Yii::t('app', 'Linked {client} account.', [
                            'client' => $this->client->getTitle()
                        ]),
                    ]);
                } else {
                    Yii::$app->getSession()->setFlash('error', [
                        Yii::t('app', 'Unable to link {client} account: {errors}', [
                            'client' => $this->client->getTitle(),
                            'errors' => json_encode($auth->getErrors()),
                        ]),
                    ]);
                }
            } else { // there's existing auth
                Yii::$app->getSession()->setFlash('error', [
                    Yii::t('app', 'Unable to link {client} account. There is another user using it.', ['client' => $this->client->getTitle()]),
                ]);
            }
        }
    }

    /**
     * @param User $user
     */
    private function updateUserInfo(User $user)
    {
        $attributes = $this->client->getUserAttributes();
        $profile = $user->profile;
        if ($profile === null) {
            $profile = new UserProfile([
                'user_id' => $user->id,
                'fullname' => $attributes['name'],
                'avatar' => $attributes['avatar'],
            ]);
            $user->link('profile', $profile);
        } else {
            if ($profile->avatar === null) {
                $profile->avatar = $attributes['avatar'];
                $profile->save();
            }
        }
        if (UserContact::findOne(['user_id' => $user->id, 'type' => 'profile', 'name' => $this->client->getId()]) === null) {
            $contact = new UserContact([
                'user_id' => $user->id,
                'type' => 'profile',
                'name' => $this->client->getId(),
                'value' => isset($attributes['profile']) ? $attributes['profile'] : null,
            ]);
            $user->link('contacts', $contact);
        }
    }
}
