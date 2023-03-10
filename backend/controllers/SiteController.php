<?php

namespace backend\controllers;

use common\models\AdminLoginForm;
use Yii;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;

/**
 * Site controller
 */
class SiteController extends Controller
{
    public $layout = 'blank';
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
                            'login'
                        ],
                        'allow' => true,
                        'roles'=> ['?']
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

    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new AdminLoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }

        $model->password = '';

        return $this->render('login', [
            'model' => $model,
        ]);
    }

}
