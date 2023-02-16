<?php

namespace backend\controllers;

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
                            'site-user-delete',
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
     *
     * @return string
     */
    public function actionSiteUserIndex():string
    {
        $page_title = 'Пользователи сайта';
        $items=SiteUser::find_for_edit()->all();
        return $this->render('SiteUserIndex',compact('items','page_title'));
    }

    public function actionSiteUserEditForm():string
    {
        $page_title = 'Пользователи сайта - ФОРМА';
        return $this->render('SiteUserEditForm',compact('page_title'));
    }

    /**
     * @throws GoodException
     */
    public function actionSiteUserDelete():void
    {
        $id=Yii::$app->getRequest()->GET('id');
        $model=new SiteUser();
        if(!($item=$model->find_for_edit()->andWhere(['id'=>$id])->one())){throw new GoodException('Пользователь сайта не найден');}
        $model->MarkAsDeleted($item);
        $this->redirect('/site-user-index');
    }
}
