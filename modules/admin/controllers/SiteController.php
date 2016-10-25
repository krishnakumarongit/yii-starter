<?php

namespace app\modules\admin\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\PasswordForm;
use app\models\EmailTemplate;
use app\models\FormatEmailTemplate;
use app\models\MailModel;
use app\models\Users;
use app\models\User;
use app\models\Constants;
use app\models\PasswordHelper;

class SiteController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays Login screen.
     *
     * @return string
     */
    public function actionIndex()
    {
        if (!Yii::$app->user->isGuest) {
            $this->redirect(Yii::$app->urlManager->createUrl("admin/users/index"));
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post())) {
            $dbUser = Users::find()->where(["email" => $model->email, "password" => PasswordHelper::encode($model->password)])->one();
            if (!count($dbUser)) {   
                $model->addError('password', Constants::LOGIN_ERROR);
            } else {
                if ($dbUser->role == 'admin' && $dbUser->status == 'active') {
                    $identity = User::findOne(['id' => $dbUser->id]);
                    Yii::$app->user->login($identity);
                    //redirecting to dashboard
                    $this->redirect(Yii::$app->urlManager->createUrl("admin/users/index"));
                } else {
                    Yii::$app->session->setFlash('error', Constants::LOGIN_ERROR);
                    return $this->goHome();
                }
            }
        }

        return $this->render('login', [
            'model' => $model,
        ]);
    }


    /**
     * Logout action.
     *
     * @return string
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();
        Yii::$app->session->setFlash('success', Constants::LOGGEDOUT_MESSAGE);
        return $this->redirect(Yii::$app->urlManager->createUrl(['admin/site/index']));
    }

    /**
     * Displays Forgotpassword screen.
     *
     * @return string
     */
    public function actionForgotpassword()
    {
        if (!Yii::$app->user->isGuest) {
            $this->redirect(Yii::$app->urlManager->createUrl("admin/users/index"));
        }

        $model = new PasswordForm();
        if ($model->load(Yii::$app->request->post())) {
            $dbUser = Users::find()->where(["email" => $model->email])->one();
            if (!count($dbUser)) {   
                $model->addError('email', Constants::EMAIL_ERROR);
            } else {
                $emailTemplate = EmailTemplate::find()->where(["type" => 'forgot password'])->one();
                if (! empty($emailTemplate)) {
                    //formatting email template
                    $message = FormatEmailTemplate::forgotPassword($emailTemplate->message, $dbUser);
                    //sending email to user
                    $mailStatus = MailModel::send($model->email, $emailTemplate->subject, $message);
                    Yii::$app->session->setFlash('success', Constants::EMAIL_SUCCESS);
                }
                return $this->redirect(Yii::$app->request->referrer);
            }
        }

        return $this->render('forgotpassword', [
            'model' => $model,
        ]);
    }

}