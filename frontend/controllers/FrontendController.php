<?php

namespace frontend\controllers;
use common\components\GoodException;
use common\components\getData;
use common\models\Country;
use common\models\Request;
use common\models\SiteUser;
use common\models\RequestForm;
use ErrorException;
use frontend\models\ContactForm;
use Yii;
use yii\base\BaseObject;
use yii\captcha\CaptchaAction;
use yii\helpers\Html;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\web\ErrorAction;
use yii\web\Response;

/**
 * Frontend controller
 */
class FrontendController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public $layout='@app/../backend/views/layouts/main.php';
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'actions' => [
                            'index',
                            'logout',
                            'request-index',
                            'api-get-users-data'
                        ],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'logout' => ['post'],
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
                'class' => ErrorAction::class,
            ],
            'captcha' => [
                'class' => CaptchaAction::class,
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Logs out the current user.
     *
     * @return Response
     */
    public function actionLogout():Response
    {
        Yii::$app->user->logout();
        return $this->goHome();
    }

    /**
     * Displays contact page.
     *
     * @return string|Response
     */
    public function actionContact():string|Response
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail(Yii::$app->params['adminEmail'])) {
                Yii::$app->session->setFlash('success', Yii::$app->params['messages']['actionContact']['success'].'.');
            } else {
                Yii::$app->session->setFlash('error', Yii::$app->params['messages']['actionContact']['error'].'.');
            }

            return $this->refresh();
        }

        return $this->render('contact', [
            'model' => $model,
        ]);
    }

    /**
     * Makes HTML code for api users data
     *
     * @throws GoodException
     */
    public function actionApiGetUsersData():string
    {
        return getData::ApiGetUsersData($this);
    }

     /**
     * Displays homepage.
     *
     * @return string
     * @throws GoodException
     */
    public function actionIndex():string
    {
        $page_title = implode(' ',['Пользователи системы',Yii::$app->params['api_system_name']]);
        return $this->render('index',compact('page_title'));
    }

}
