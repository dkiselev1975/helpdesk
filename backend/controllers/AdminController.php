<?php

namespace backend\controllers;

use common\models\SiteUser;
use Yii;
use yii\base\ErrorException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
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
     * @throws GoodException
     */
    private function getUserIds(int $start_index=1):array
    {
        $input_data=[
            "list_info"=>[
                "sort_field"=>"name",
                "start_index"=>$start_index,
                "sort_order"=>"asc",
                "row_count"=>100,
                "get_total_count"=>true,
            ],
            "fields_required"=>["id","name"]
        ];
        /*echo "start_index_start:".$start_index."<br>";*/
        ?><pre><?var_dump($input_data);?></pre><?
        $options = [
            'http'=>[
                "method"=>"GET",
                "header"=>"authtoken:E4661F58-E35B-48CA-BA1C-1C19C385AC69\r\n"."Content-Type:application/json; charset=UTF-8"
            ],
        ];
        static $data=[];
        //if($start_index<1){throw new GoodException('Ошибка загрузки данных из helpdesk','Индекс начального элемента не должен быть меньше 1.');}
        $file=@file_get_contents(
            'https://hq-helpdesk:8080/api/v3/users?input_data='.urlencode(json_encode($input_data)),
            false,
            stream_context_create($options));
        if($file===false)
            {
            throw new GoodException('Ошибка загрузки данных из helpdesk',error_get_last()['message'],buttons: [['title'=>'Вернуться','href'=> Yii::$app->request->referrer]]);
            }
        $loaded_data = json_decode($file,true);

        $data=array_merge($data,$loaded_data['users']);
        //$start_index+=$loaded_data['list_info']['row_count'];
        /**/?><!--<p>****</p>--><?/*
        echo "total_count:".$total_count."<br>";
        echo "count(data):".count($data)."<br>";
        echo "loaded_data['list_info']['page']:".$loaded_data['list_info']['page']."<br>";
        echo "loaded_data['list_info']['row_count']:".$loaded_data['list_info']['row_count']."<br>";
        echo "start_index:".$start_index."<br>";*/
        //if ($total_count>=$start_index)
        if ($loaded_data['list_info']['has_more_rows'])
            {
            $start_index=$loaded_data['list_info']['page']*$loaded_data['list_info']['row_count']+1;
            $this->getUserIds($start_index);
            }
        return $data;
    }

    /**
     * Displays homepage.
     *
     * @return string
     * @throws GoodException
     */
    public function actionIndex():string
    {
        try
            {
            $users_list=$this->getUserIds();
            $users_data=[];
            foreach ($users_list as $user)
                {
                $options = [
                    'http'=>[
                        "method"=>"GET",
                        "header"=>"authtoken:E4661F58-E35B-48CA-BA1C-1C19C385AC69\r\n"."Content-Type:application/json; charset=UTF-8"
                    ],
                ];
                $file=@file_get_contents(
                    'https://hq-helpdesk:8080/api/v3/users/'.$user['id'],
                    false,
                    stream_context_create($options));
                if($file===false)
                {
                    throw new GoodException('Ошибка загрузки данных из helpdesk',error_get_last()['message'],buttons: [['title'=>'Вернуться','href'=> Yii::$app->request->referrer]]);
                }
                $users_data[]=json_decode($file,true)['user'];
                /*echo $user['id']."|".$user['name']."<br>";*/
                /**/?><!--<pre><?/*var_dump($user_data);*/?></pre>--><?
                }
            //if(!is_array($data)){throw new GoodException('Ошибка загрузки данных из helpdesk','Данные не являются массивом');}
            }
        catch (GoodException $exception)
            {
            throw $exception;
            }
        /**/?><!--<pre><?/*var_dump($users_data);*/?></pre>--><?
        /*echo count($users_list);*/
        /**/?><!--<pre><?/*var_dump($users_list[0]);*/?></pre><?/*
        */?><pre><?/*var_dump($users_list[count($users_list)-1]);*/?></pre>--><?
        return $this->render('index',compact('users_data'));
        //return "";
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
}
