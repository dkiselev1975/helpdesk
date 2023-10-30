<?php

namespace backend\controllers;

use common\components\GoodException;
use common\models\AdminUser;
use common\models\SiteUser;
use common\models\Company;
use common\components\getData;

use common\models\User;
use frontend\models\SignupForm;
use Yii;
use yii\base\BaseObject;
use yii\base\ErrorException;
use yii\base\Exception;
use yii\base\InvalidArgumentException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\helpers\Url;
use yii\web\Controller;
use yii\web\ErrorAction;
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
                        'actions' => [
                            'index',
                            'logout',
                            'site-user-index',
                            'site-user-edit-form',
                            'site-user-delete',

                            'admin-user-create',

                            'company-index',
                            'company-edit-form',
                            'company-delete',

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
        ];
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
     */
    public function actionIndex():string
    {
        $page_title = implode(' ',['Пользователи системы',Yii::$app->params['api_system_name']]);
        return $this->render('index',compact('page_title'));
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
        $empty_list_phrase='Список пользователей пуст';
        $items=SiteUser::find()->orderBy(['username'=>SORT_ASC])->all();
        return $this->render('SiteUserIndex',compact('items','page_title','empty_list_phrase'));
    }

    /**
     *
     * @return string
     */
    public function actionAdminUserCreate():string
    {
        $page_title = 'Добавление администратора';
        $username='';
        $password='';
        $email='';
        $user = new AdminUser();
        $user->username = $username;
        $user->email = $email;
        $user->setPassword($password);
        $user->generateAuthKey();
        //return $user->save();
    }

    /**
     *
     * @return string
     */
    public function actionCompanyIndex():string
    {
        $page_title = 'Компании';
        $empty_list_phrase='Список компаний пуст';
        $items=Company::find()->all();
        return $this->render('CompanyIndex',compact('items','page_title','empty_list_phrase'));
    }

    /**
     * Редактирование и создание пользователя сайта
     * @return ?string
     *
     * @throws GoodException
     */
    public function actionSiteUserEditForm():string|response|bool
    {
        $form=new SignupForm();
        $redirect_url=Url::to(['site-user-index']);
        try
            {
            if ($id = Yii::$app->getRequest()->GET('id')) {
                // Редактирование и сохранение данных о пользователе
                Yii::Debug('Редактирование и сохранение данных о пользователе');
                $item = SiteUser::find()->andWhere(['id' => $id])->one();
                if(empty($item)){throw new GoodException('Пользователь сайта не найден');}
                Yii::Warning(Yii::$app->request->post());
                if ($item->load(Yii::$app->request->post())){
                    //данные пришли из формы - сохранение
                    Yii::Debug('Редактирование и сохранение данных о пользователе');
                    if (!$item->validate())
                        {
                        throw new ErrorException('Ошибка валидации', 0);
                        }
                    if (!$item->save())
                        {
                        throw new ErrorException('Ошибка сохранения в БД', 1);
                        }
                    return $this->response->redirect($redirect_url);
                    }
                else
                    {
                    $page_title = 'Изменение пользователя сайта';
                    Yii::Debug('Изменение пользователя сайта');
                    return $this->render('SiteUserEditForm', ['model'=>$item, 'page_title'=>$page_title]);
                    }
                }
            else
                {
                $page_title = 'Добавить пользователя сайта';
                //Сохраненние данных нового пользователя
                if ($form->load(Yii::$app->request->post()))
                    {
                    Yii::Warning(Yii::$app->request->post());
                    /*$item=new SiteUser();
                    $item['status'] = SiteUser::STATUS_ACTIVE;
                    $item->setPassword($form->password);
                    $item->generateAuthKey();*/
                    //POST-запрос

                    if ($form->load(Yii::$app->request->post()) && $form->signup()) {
                        return $this->response->redirect($redirect_url);
                        }
                    else
                        {
                        return $this->render('SiteUserEditForm', ['model' => $form,'page_title'=>$page_title]);
                        }
                    }
                else
                    {
                    //Форма нового пользователя
                    Yii::Debug(Yii::$app->urlManagerFrontend->createAbsoluteUrl(['site/verify-email']));
                    Yii::Debug('Форма нового пользователя');

                    $form->username='test';
                    $form->person_name='Тест';
                    $form->person_patronymic='Тестович';
                    $form->person_surname='Тестов';
                    $form->email='tahoe99@mail.ru';
                    $form->password=Yii::$app->security->generateRandomString(12);
                    $form->phone_office='+7 (495) 543-91-31+196';
                    $form->phone_mobile='+7 (916) 688-58-84';
                    $form->company_id='';
                    $form->status='';
                    $form->note='';

                    return $this->render('SiteUserEditForm', ['model'=>$form, 'page_title'=>$page_title]);
                    }
                }
            }
        catch (Exception | InvalidArgumentException | ErrorException $error)
            {
            /*$page_title = $error->getMessage();
            $errors=$item->getErrors();*/
            Yii::Error('Ошибка создания пользователя');
            throw new GoodException('Ошибка создания пользователя',$error->getMessage());
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
        $redirect_url=Url::to(['company-index']);
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
        $redirect_url=Url::to(['site-user-index']);
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
        $redirect_url=Url::to(['company-index']);
        $id=Yii::$app->getRequest()->GET('id');
        $model=new Company();
        if(!($item=$model->find()->andWhere(['id'=>$id])->one())){throw new GoodException('Компания не найдена');}
        $model->MarkAsDeleted($item);
        $this->redirect($redirect_url);
    }
}
