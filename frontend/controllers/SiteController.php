<?php

namespace frontend\controllers;

use backend\controllers\GoodException;
use common\models\SiteLoginForm;
use frontend\models\PasswordResetRequestForm;
use frontend\models\ResendVerificationEmailForm;
use frontend\models\ResetPasswordForm;
use frontend\models\SignupForm;
use frontend\models\VerifyEmailForm;
use Yii;
use yii\base\InvalidArgumentException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\web\Response;

/**
 * Site controller
 */
class SiteController extends Controller
{
    public $layout='@app/../backend/views/layouts/blank.php';
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    /*см. 'errorHandler' в ./config/main.php*/
                    /*адрес 'site/error'*/
                    [
                        'actions'=>['error'],
                        'allow' => true,/*роль не указывать*/
                    ],
                    [
                        'actions' => [
                            'login',
                            'signup',
                            'request-password-reset',
                            'resend-verification-email',
                            'reset-password',
                            'verify-email',
                        ],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => \yii\web\ErrorAction::class,
                'view'=>'@app/../backend/views/site/error.php',
            ],
        ];
    }

    /**
     * Login action.
     *
     * @return string|Response
     */

    /**
     * Logs in a user.
     *
     * @return string|Response
     */
    public function actionLogin():string|Response
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new SiteLoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }

        $model->password = '';

        return $this->render('login', [
            'model' => $model,
        ]);
    }


    /**
     * Signs user up.
     *
     * @return string|Response
     * @throws GoodException
     */
    public function actionSignup(): string|Response
    {
        $model = new SignupForm();
        if ($model->load(Yii::$app->request->post()) && $model->signup()) {
            Yii::$app->session->setFlash('success', Yii::$app->params['messages']['actionSignup']['success'].'.');
            //return $this->goHome();
            return $this->response->redirect('/site/login');
        }

        return $this->render('signup', [
            'model' => $model,
        ]);
    }

    /**
     * Requests password reset.
     *
     * @return string|Response
     */
    public function actionRequestPasswordReset():string|Response
    {
        $model = new PasswordResetRequestForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail()) {
                Yii::$app->session->setFlash('success', Yii::$app->params['messages']['actionRequestPasswordReset']['success'].'.');

                return $this->goHome();
            }

            Yii::$app->session->setFlash('error', Yii::$app->params['messages']['actionRequestPasswordReset']['error'].'.');
        }

        return $this->render('requestPasswordResetToken', [
            'model' => $model,
        ]);
    }

    /**
     * Resets password.
     *
     * @param string $token
     * @return mixed
     * @throws BadRequestHttpException
     */
    public function actionResetPassword($token):string|Response
    {
        try {
            $model = new ResetPasswordForm($token);
        } catch (InvalidArgumentException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }

        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->resetPassword()) {
            Yii::$app->session->setFlash('success', Yii::$app->params['messages']['actionResetPassword']['success'].'.');

            return $this->goHome();
        }

        return $this->render('resetPassword', [
            'model' => $model,
        ]);
    }

    /**
     * Verify email address
     *
     * @param string $token
     * @throws BadRequestHttpException
     * @return Response
     */
    public function actionVerifyEmail($token):Response
    {
        try {
            $model = new VerifyEmailForm($token);
        } catch (InvalidArgumentException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }
        if (($user = $model->verifyEmail()) && Yii::$app->user->login($user)) {
            Yii::$app->session->setFlash('success', Yii::$app->params['messages']['actionVerifyEmail']['success'].'!');
            return $this->goHome();
        }

        Yii::$app->session->setFlash('error', Yii::$app->params['messages']['actionVerifyEmail']['error'].'.');
        return $this->goHome();
    }

    /**
     * Resend verification email
     *
     * @return string|Response
     */
    public function actionResendVerificationEmail():string|Response
    {
        $model = new ResendVerificationEmailForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail()) {
                Yii::$app->session->setFlash('success', Yii::$app->params['messages']['actionResendVerificationEmail']['success'].'.');
                return $this->goHome();
            }
            Yii::$app->session->setFlash('error', Yii::$app->params['messages']['actionResendVerificationEmail']['error'].'.');
        }

        return $this->render('resendVerificationEmail', [
            'model' => $model
        ]);
    }
}
