<?php

namespace backend\controllers;

use common\models\Company;
use common\models\Country;
use common\models\Request;
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
                        'actions' => [
                            'index',
                            'logout',
                            'site-user-index',
                            'site-user-edit-form',
                            'site-user-delete',
                            'company-index',
                            'company-edit-form',
                            'company-delete',

                            'country-index',
                            'country-edit-form',
                            'country-delete',

                            'request-index',
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
        $items=Yii::$app->db->createCommand("
select
if(grouping(date_format(from_unixtime(`request`.`updated_at`),'%Y'))=1,'Всего:',
if(grouping(date_format(from_unixtime(`request`.`updated_at`),'%m'))=1,'Всего за год:',
if(grouping(date_format(from_unixtime(`request`.`updated_at`),'%d'))=1,'Всего за мес.:',''))) as `user_id`,
if(`user_id` is not null,group_concat(distinct concat_ws(' ',`site_user`.`person_surname`,concat(substring(`site_user`.`person_name`,1,1),'.',substring(`site_user`.`person_patronymic`,1,1),'.'))),'') as `name`,
count(`request`.`id`) as `requests`,
sum(`price_of_request`) as `price`,
date_format(from_unixtime(`request`.`updated_at`),'%d') as `day`,
date_format(from_unixtime(`request`.`updated_at`),'%m') as `month`,
date_format(from_unixtime(`request`.`updated_at`),'%Y') as `year`,
grouping(`user_id`) AS `grp_user_id`,
grouping(date_format(from_unixtime(`request`.`updated_at`),'%d')) AS `grp_day`,
grouping(date_format(from_unixtime(`request`.`updated_at`),'%m')) AS `grp_month`,
grouping(date_format(from_unixtime(`request`.`updated_at`),'%Y')) AS `grp_year`
from `request`
left join `site_user` on `request`.`user_id`=`site_user`.`id`
where `debug_flag`=0 and `repeated_flag`=0 and `response_success`=1 and `price_of_request` is not null
group by `year`,`month`,`day`,`user_id` with rollup
having `grp_user_id`=0 or `grp_day`=1
order by 
`grp_year`,
`month` desc,
`grp_month`,
`grp_day`,
`day` desc,
`name`")->queryAll();
        return $this->render('index',compact('items'));
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
    public function actionCompanyIndex():string
    {
        $page_title = 'Компании';
        $empty_list_phrase='Список компаний пуст';
        $items=Company::find()->all();
        return $this->render('CompanyIndex',compact('items','page_title','empty_list_phrase'));
    }

    /**
     *
     * @return string
     */
    public function actionCountryIndex():string
    {
        $page_title = 'Страны и тарифы';
        $empty_list_phrase='Список стран пуст';
        $items=Country::find()->orderBy('name')->all();
        return $this->render('CountryIndex',compact('items','page_title','empty_list_phrase'));
    }

    /**
     *
     * @return string
     */
    public function actionRequestIndex():string
    {
        $page_title = 'Запросы';
        $empty_list_phrase='Список запросов пуст';
        $items=Request::find()->orderBy(['updated_at'=>SORT_DESC])->all();
        return $this->render('RequestIndex',compact('items','page_title','empty_list_phrase'));
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
     * Редактирование и создание компании
     * @return ?string
     *
     * @throws GoodException
     */
    public function actionCountryEditForm():?string
    {
        $redirect_url='/country-index';
        $item=new Country();
        try {
            if ($id = Yii::$app->getRequest()->GET('id')) {

                $item = Country::find()->andWhere(['id' => $id])->one();
                if(empty($item)){throw new GoodException('Страна не найдена');}
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
                    return $this->render('CountryEditForm', compact('item', 'page_title'));
                }
            } else {
                $item['status'] =Country::STATUS_ACTIVE;
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
                    $page_title = 'Добавить страну и тариф';
                    return $this->render('CountryEditForm', compact('item', 'page_title'));
                }
            }
        }
        catch (ErrorException $error)
        {
            $page_title = $error->getMessage();
            $errors=$item->getErrors();
            return $this->render('CountryEditForm',compact('errors','page_title'));
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

    /**
     * @throws GoodException
     * Удаление страны
     */
    public function actionCountryDelete():void
    {
        $redirect_url='/country-index';
        $id=Yii::$app->getRequest()->GET('id');
        $model=new Country();
        if(!($item=$model->find()->andWhere(['id'=>$id])->one())){throw new GoodException('Страна не найдена');}
        $model->MarkAsDeleted($item);
        $this->redirect($redirect_url);
    }
}
