<?php

namespace app\controllers;

use accessUser\models\User;
use accessUser\models\UserProfile;
use app\classes\AuthFilter;
use app\classes\AuthHandler;
use app\classes\GuestFilter;
use app\classes\UploadImage;
use app\models\form\ChangePassword;
use app\models\form\ChangeUserEmail;
use app\models\form\Login;
use app\models\form\PasswordResetRequest;
use app\models\form\ResetPassword;
use app\models\form\Signup;
use Yii;
use yii\base\InvalidParamException;
use yii\filters\VerbFilter;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

/**
 * User controller
 */
class UserController extends Controller
{

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'auth'  => [
                'class' => AuthFilter::className(),
                'only'  => ['logout'],
            ],
            'guest' => [
                'class' => GuestFilter::className(),
                'only'  => ['signup', 'reset-password', 'login', 'request-password-reset'],
            ],
            'verbs' => [
                'class'   => VerbFilter::className(),
                'actions' => [
                    'logout'       => ['post'],
                ],
            ],
        ];
    }

    public function actions()
    {
        return [
            'auth' => [
                'class'           => 'yii\authclient\AuthAction',
                'successCallback' => [$this, 'onAuthSuccess'],
            ],
        ];
    }

    public function onAuthSuccess($client)
    {
        (new AuthHandler($client))->handle();
    }

    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new Login();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        } else {
            return $this->render('login', [
                'model' => $model,
            ]);
        }
    }

    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    public function actionSignup()
    {
        $model = new Signup();
        if ($model->load(Yii::$app->request->post())) {
            if ($user = $model->signup()) {
                if ($user->status == User::STATUS_ACTIVE) {
                    Yii::$app->getUser()->login($user);
                }
                return $this->goHome();
            }
        }

        return $this->render('signup', [
            'model' => $model,
        ]);
    }

    public function actionActivate($token)
    {
        $data = Yii::$app->tokenManager->getTokenData($token, 'activate.account');
        if ($data !== false) {
            list($action, $userId) = $data;
            if ($user = User::findOne(['id' => $userId, 'status' => User::STATUS_PANDING])) {
                if ($action == 'activate') {
                    $user->status = User::STATUS_ACTIVE;
                    if ($user->save() && Yii::$app->getUser()->login($user)) {
                        Yii::$app->tokenManager->deleteToken($token);
                        return $this->goHome();
                    }
                } else {
                    $user->delete();
                    Yii::$app->tokenManager->deleteToken($token);
                    return $this->goHome();
                }
            }
        }
        throw new \yii\base\UserException('Invalid link');
    }

    public function actionRequestPasswordReset()
    {
        $model = new PasswordResetRequest();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail()) {
                Yii::$app->getSession()->setFlash('success', 'Check your email for further instructions.');

                return $this->goHome();
            } else {
                Yii::$app->getSession()->setFlash('error', 'Sorry, we are unable to reset password for email provided.');
            }
        }

        return $this->render('requestPasswordResetToken', [
            'model' => $model,
        ]);
    }

    public function actionResetPassword($token)
    {
        try {
            $model = new ResetPassword($token);
        } catch (InvalidParamException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }

        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->resetPassword()) {
            Yii::$app->getSession()->setFlash('success', 'New password was saved.');

            return $this->goHome();
        }

        return $this->render('resetPassword', [
            'model' => $model,
        ]);
    }
}
