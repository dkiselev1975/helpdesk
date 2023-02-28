<?php

namespace backend\controllers;

use common\models\Company;
use common\models\SiteUser;
use Yii;
use yii\base\BaseObject;
use yii\base\ErrorException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;

/**
 * Admin controller
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
                            'company-index',
                            'company-edit-form',
                            'company-delete',
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
        $page_title = 'Пользователи';
        $items=SiteUser::find()->all();
        return $this->render('SiteUserIndex',compact('items','page_title'));
    }

    /**
     *
     * @return string
     */
    public function actionCompanyIndex():string
    {
        $page_title = 'Компании';
        $items=Company::find()->all();
        return $this->render('CompanyIndex',compact('items','page_title'));
    }

    /*public function actionSiteUserEditForm():string
    {
        $page_title = 'Пользователи сайта - ФОРМА';
        return $this->render('SiteUserEditForm',compact('page_title'));
    }*/


    /**
     * Редактирование и создание пользователя сайта
     * @return ?string
     *
     * @throws GoodException
     */
    public function actionSiteUserEditForm():?string
    {
        $redirect_url='/site-user-index';
        $item=new SiteUser();
        try {
            if ($id = Yii::$app->getRequest()->GET('id')) {

                $item = SiteUser::find()->andWhere(['id' => $id])->one();
                if(empty($item)){throw new GoodException('Пользователь сайта не найден');}
                //Yii::Warning(Yii::$app->request->post());
                if ($item->load(Yii::$app->request->post())) {
                    if (!$item->validate()) {
                        throw new ErrorException('Ошибка валидации', 0);
                    }
                    if (!$item->save()) {
                        throw new ErrorException('Ошибка сохранения в БД', 1);
                    }

                    $this->redirect($redirect_url);
                    return null;
                } else {
                    $page_title = 'Изменение пользователя сайта';
                    return $this->render('SiteUserEditForm', compact('item', 'page_title'));
                }
            } else {
                $item['status'] =SiteUser::STATUS_ACTIVE;
                if ($item->load(Yii::$app->request->post())) {
                    if (!$item->validate()) {
                        throw new ErrorException('Ошибка валидации', 0);
                    }
                    if (!$item->save()) {
                        throw new ErrorException('Ошибка сохранения в БД', 1);
                    }
                    $this->redirect($redirect_url);
                    return null;
                } else {
                    $page_title = 'Добавить пользователя сайта';
                    return $this->render('SiteUserEditForm', compact('item', 'page_title'));
                }
            }
        }
        catch (ErrorException $error)
        {
            $page_title = $error->getMessage();
            $errors=$item->getErrors();
            return $this->render('SiteUserEditForm',compact('errors','page_title'));
        }
    }

    /**
     * Редактирование и создание компании
     * @return ?string
     *
     * @throws GoodException
     */
    public function actionCompanyEditForm():?string
    {
        $redirect_url='/company-index';
        $item=new Company();
        try {
            if ($id = Yii::$app->getRequest()->GET('id')) {

                $item = Company::find()->andWhere(['id' => $id])->one();
                if(empty($item)){throw new GoodException('Компания не найдена');}
                //Yii::Warning(Yii::$app->request->post());
                if ($item->load(Yii::$app->request->post())) {
                    if (!$item->validate()) {
                        throw new ErrorException('Ошибка валидации', 0);
                    }
                    if (!$item->save()) {
                        throw new ErrorException('Ошибка сохранения в БД', 1);
                    }

                    $this->redirect($redirect_url);
                    return null;
                } else {
                    $page_title = 'Изменение компании';
                    return $this->render('CompanyEditForm', compact('item', 'page_title'));
                }
            } else {
                $item['status'] =Company::STATUS_ACTIVE;
                if ($item->load(Yii::$app->request->post())) {
                    if (!$item->validate()) {
                        throw new ErrorException('Ошибка валидации', 0);
                    }
                    if (!$item->save()) {
                        throw new ErrorException('Ошибка сохранения в БД', 1);
                    }
                    $this->redirect($redirect_url);
                    return null;
                } else {
                    $page_title = 'Добавить компанию';
                    return $this->render('CompanyEditForm', compact('item', 'page_title'));
                }
            }
        }
        catch (ErrorException $error)
        {
            $page_title = $error->getMessage();
            $errors=$item->getErrors();
            return $this->render('CompanyEditForm',compact('errors','page_title'));
        }
    }

    /**
     * @throws GoodException
     * Удаление пользователя сайта
     */
    public function actionSiteUserDelete():void
    {
        $redirect_url='/site-user-index';
        $id=Yii::$app->getRequest()->GET('id');
        $model=new SiteUser();
        if(!($item=$model->find()->andWhere(['id'=>$id])->one())){throw new GoodException('Пользователь сайта не найден');}
        $model->MarkAsDeleted($item);
        $this->redirect($redirect_url);
    }

    /**
     * @throws GoodException
     * Удаление компании
     */
    public function actionCompanyDelete():void
    {
        $redirect_url='/company-index';
        $id=Yii::$app->getRequest()->GET('id');
        $model=new Company();
        if(!($item=$model->find()->andWhere(['id'=>$id])->one())){throw new GoodException('Компания не найдена');}
        $model->MarkAsDeleted($item);
        $this->redirect($redirect_url);
    }
}
