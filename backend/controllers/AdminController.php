<?php

namespace backend\controllers;

use Codeception\Util\Debug;
use common\models\AdminLoginForm;
use common\models\SiteUser;
use Yii;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;

/**
 * AdminController
 */
class AdminController extends Controller
{

    public $layout = 'main';

    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'actions' => ['error'],
                        'allow' => true,
                    ],
                    [
                        'actions' => [
                            'logout',
                            'index',
                            'site-user-index',
                            'site-user-edit-form',
                            'site-user-edit-form/<id:\d+>',
                            'site-user-delete/<id:\d+>',
                            'site-user-update',
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
                'class' => \yii\web\ErrorAction::class,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        //Yii::warning(Yii::$app->params['timeZone']);
        return $this->render('index');
    }

    /**
     * Logout action.
     *
     * @return Response
     */

    public function actionLogout():Response
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * .
     *
     * @return string
     */
    public function actionSiteUserIndex():string
    {
        $page_title = 'Пользователи сайта';
        $items=SiteUser::find_for_edit()->all();
        return $this->render('SiteUserIndex',compact('items','page_title'));
    }
}
