<?php

namespace backend\controllers;

use common\models\SiteUser;
use Yii;
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
     * @throws GoodException
     */
    private function getData(int $start_index=1):array
    {
        $max_per_page=100;
        $input_data=
            [
                "list_info" => [
                    "sort_field"=> "name",
                    "start_index"=> $start_index,
                    "sort_order"=> "asc",
                    "row_count"=> $max_per_page,
                    "get_total_count"=> true,
                ],
                /*"fields_required"=> [
                    "name",
                ],*/
            ];

        $options = [
            'http'=>[
                "method"=>"GET",
                "header"=>"authtoken:E4661F58-E35B-48CA-BA1C-1C19C385AC69\r\n"."Content-Type:application/json; charset=UTF-8"
            ],
        ];
        static $data=[];
        $context = stream_context_create($options);

        if($start_index<1){throw new GoodException('Ошибка загрузки данных из helpdesk','Индекс начального элемента не должен быть меньше 1.');}
        try {
            $loaded_data = json_decode(file_get_contents(
                'https://hq-helpdesk:8080/api/v3/users?input_data='.urlencode(json_encode($input_data)),
                false,
                $context),
                true);
        }

        catch (ErrorException $error){
            throw new GoodException('Ошибка загрузки данных из helpdesk',$error->getMessage());
        }

        $total_count=$loaded_data['list_info']['total_count'];
        //$page_records=$loaded_data['list_info']['page']*$loaded_data['list_info']['row_count'];
        //var_dump($loaded_data['users']);
        $data=array_merge($data,$loaded_data['users']);
        $start_index+=$loaded_data['list_info']['row_count'];
        ?><p>****</p><?
        echo "total_count:".$total_count."<br>";
        echo "count(data):".count($data)."<br>";
        echo "loaded_data['list_info']['page']:".$loaded_data['list_info']['page']."<br>";
        echo "loaded_data['list_info']['row_count']:".$loaded_data['list_info']['row_count']."<br>";
        echo "start_index:".$start_index."<br>";
        if ($total_count>=$start_index)
            {
            $this->getData($start_index);
            }
        return $data;
    }

    /**
     * Displays homepage.
     *
     * @return string
     * @throws GoodException
     */
    public function actionIndex()
    {

        /*$obj = json_decode($json);
        $users=$obj->users;*/
        //$users=json_decode('{"response_status":[{"status_code":2000,"status":"success"}],"list_info":{"has_more_rows":true,"start_index":1,"row_count":10},"users":[{"email_id":null,"extension":null,"description":"-","is_vipuser":false,"reporting_to":null,"type":"Technician","citype":{"name":"User","id":3},"cost_per_hour":"0.00","org_user_status":"ACTIVE","id":"5","department":{"site":{"name":"812 ИТ","id":"24"},"name":"Отдел информационных технологий","id":"364"},"first_name":null,"created_time":{"display_value":"25-07-2023 16:09:13","value":"1690290553609"},"is_technician":true,"jobtitle":"Администратор системы","mobile":"1234567890","profile_pic":{"content-url":"/images/default-profile-pic2.svg"},"last_name":null,"sms_mail_id":null,"middle_name":null,"created_by":null,"ciid":"18","login_name":"administrator","phone":null,"sip_user":null,"employee_id":"009","domain":null,"name":"administrator","user_udf_fields":{"udf_pick_303":"СТР","udf_sline_302":"99","udf_sline_306":null},"enable_telephony":false,"status":"ACTIVE"},{"email_id":null,"extension":null,"description":"-","is_vipuser":false,"reporting_to":null,"type":"User","citype":{"name":"User","id":3},"cost_per_hour":"0.00","org_user_status":"ACTIVE","id":"155","department":{"site":{"name":"Разработчики  КОММОД","id":"308"},"name":"Отдел разработки","id":"384"},"first_name":"Владимир","created_time":{"display_value":"25-07-2023 16:20:02","value":"1690291202996"},"is_technician":false,"jobtitle":"Начальник отдела","mobile":null,"profile_pic":{"content-url":"/images/default-profile-pic2.svg"},"last_name":"Расходчиков","sms_mail_id":null,"middle_name":"Павлович","created_by":{"email_id":null,"phone":null,"name":"administrator","mobile":"1234567890","profile_pic":{"content-url":"/images/default-profile-pic2.svg"},"is_vipuser":false,"id":"5","department":{"site":{"name":"812 ИТ","id":"24"},"name":"Отдел информационных технологий","id":"364"}},"ciid":"232","login_name":"raskhodtchikov_vp","requester_allowed_to_view":null,"phone":"203","sip_user":null,"employee_id":null,"domain":{"canonical_name":"str.local","name":"STR.LOCAL","id":"1"},"name":"Расходчиков Владимир Павлович","user_udf_fields":{"udf_pick_303":"АТР","udf_sline_302":"АТР 6 этаж","udf_sline_306":null},"enable_telephony":false,"status":"ACTIVE"},{"email_id":"Indyushkin_em@solid-tr.ru","extension":null,"description":"-","is_vipuser":false,"reporting_to":null,"type":"User","citype":{"name":"User","id":3},"cost_per_hour":"0.00","org_user_status":"ACTIVE","id":"228","department":{"site":{"name":"812 ИТ","id":"24"},"name":"Отдел информационных технологий","id":"364"},"first_name":"Евгений","created_time":{"display_value":"25-07-2023 16:20:30","value":"1690291230940"},"is_technician":false,"jobtitle":"Программист 1С","mobile":null,"profile_pic":{"content-url":"/images/default-profile-pic2.svg"},"last_name":"Индюшкин","sms_mail_id":null,"middle_name":"Михайлович","created_by":{"email_id":null,"phone":null,"name":"administrator","mobile":"1234567890","profile_pic":{"content-url":"/images/default-profile-pic2.svg"},"is_vipuser":false,"id":"5","department":{"site":{"name":"812 ИТ","id":"24"},"name":"Отдел информационных технологий","id":"364"}},"ciid":"324","login_name":"indyushkin_em","requester_allowed_to_view":null,"phone":"192","sip_user":null,"employee_id":null,"domain":{"canonical_name":"str.local","name":"STR.LOCAL","id":"1"},"name":"Индюшкин Евгений Михайлович","user_udf_fields":{"udf_pick_303":"АТР","udf_sline_302":"96","udf_sline_306":null},"enable_telephony":false,"status":"ACTIVE"},{"email_id":"Karuzin_IA@solid-tr.ru","extension":null,"description":"-","is_vipuser":false,"reporting_to":null,"type":"Technician","citype":{"name":"User","id":3},"cost_per_hour":"0.00","org_user_status":"ACTIVE","id":"229","department":{"site":{"name":"812 ИТ","id":"24"},"name":"Отдел информационных технологий","id":"364"},"first_name":"Игорь","created_time":{"display_value":"25-07-2023 16:20:31","value":"1690291231302"},"is_technician":true,"jobtitle":"Системный администратор","mobile":"915 460 34 09","profile_pic":{"content-url":"/images/default-profile-pic2.svg"},"last_name":"Карузин","sms_mail_id":null,"middle_name":"Андреевич","created_by":{"email_id":null,"phone":null,"name":"administrator","mobile":"1234567890","profile_pic":{"content-url":"/images/default-profile-pic2.svg"},"is_vipuser":false,"id":"5","department":{"site":{"name":"812 ИТ","id":"24"},"name":"Отдел информационных технологий","id":"364"}},"ciid":"325","login_name":"karuzin_ia","phone":"230","sip_user":null,"employee_id":null,"domain":{"canonical_name":"str.local","name":"STR.LOCAL","id":"1"},"name":"Карузин Игорь Андреевич","user_udf_fields":{"udf_pick_303":"АТР","udf_sline_302":"99","udf_sline_306":"WS-173"},"enable_telephony":false,"status":"ACTIVE"},{"email_id":"kiselev_dn@solid-tr.ru","extension":null,"description":"-","is_vipuser":false,"reporting_to":null,"type":"Technician","citype":{"name":"User","id":3},"cost_per_hour":"0.00","org_user_status":"ACTIVE","id":"230","department":{"site":{"name":"812 ИТ","id":"24"},"name":"Отдел информационных технологий","id":"364"},"first_name":"Дмитрий","created_time":{"display_value":"25-07-2023 16:20:31","value":"1690291231738"},"is_technician":true,"jobtitle":"Веб Программист","mobile":null,"profile_pic":{"content-url":"/images/default-profile-pic2.svg"},"last_name":"Киселев","sms_mail_id":null,"middle_name":"Николаевич","created_by":{"email_id":null,"phone":null,"name":"administrator","mobile":"1234567890","profile_pic":{"content-url":"/images/default-profile-pic2.svg"},"is_vipuser":false,"id":"5","department":{"site":{"name":"812 ИТ","id":"24"},"name":"Отдел информационных технологий","id":"364"}},"ciid":"326","login_name":"kiselev_dn","phone":"196","sip_user":null,"employee_id":null,"domain":{"canonical_name":"str.local","name":"STR.LOCAL","id":"1"},"name":"Киселев Дмитрий Николаевич","user_udf_fields":{"udf_pick_303":"АТР","udf_sline_302":"93","udf_sline_306":null},"enable_telephony":false,"status":"ACTIVE"},{"email_id":"Kulikov_sv@solid-tr.ru","extension":null,"description":"-","is_vipuser":false,"reporting_to":null,"type":"User","citype":{"name":"User","id":3},"cost_per_hour":"0.00","org_user_status":"ACTIVE","id":"231","department":{"site":{"name":"812 ИТ","id":"24"},"name":"Отдел информационных технологий","id":"364"},"first_name":"Сергей","created_time":{"display_value":"25-07-2023 16:20:32","value":"1690291232122"},"is_technician":false,"jobtitle":"Консультант-аналитик 1С","mobile":"+7 916 266 17 54","profile_pic":{"content-url":"/images/default-profile-pic2.svg"},"last_name":"Куликов","sms_mail_id":null,"middle_name":"Викторович","created_by":{"email_id":null,"phone":null,"name":"administrator","mobile":"1234567890","profile_pic":{"content-url":"/images/default-profile-pic2.svg"},"is_vipuser":false,"id":"5","department":{"site":{"name":"812 ИТ","id":"24"},"name":"Отдел информационных технологий","id":"364"}},"ciid":"327","login_name":"kulikov_sv","requester_allowed_to_view":null,"phone":"202","sip_user":null,"employee_id":null,"domain":{"canonical_name":"str.local","name":"STR.LOCAL","id":"1"},"name":"Куликов Сергей Викторович","user_udf_fields":{"udf_pick_303":"АТР","udf_sline_302":"97","udf_sline_306":"WS-136"},"enable_telephony":false,"status":"ACTIVE"},{"email_id":"lychko_vv@solid-tr.ru","extension":null,"description":"-","is_vipuser":false,"reporting_to":null,"type":"User","citype":{"name":"User","id":3},"cost_per_hour":"0.00","org_user_status":"ACTIVE","id":"232","department":{"site":{"name":"812 ИТ","id":"24"},"name":"Отдел информационных технологий","id":"364"},"first_name":"Владимир","created_time":{"display_value":"25-07-2023 16:20:32","value":"1690291232541"},"is_technician":false,"jobtitle":"Программист 1С","mobile":"+7 906 047 67 79","profile_pic":{"content-url":"/images/default-profile-pic2.svg"},"last_name":"Лычко","sms_mail_id":null,"middle_name":"Витальевич","created_by":{"email_id":null,"phone":null,"name":"administrator","mobile":"1234567890","profile_pic":{"content-url":"/images/default-profile-pic2.svg"},"is_vipuser":false,"id":"5","department":{"site":{"name":"812 ИТ","id":"24"},"name":"Отдел информационных технологий","id":"364"}},"ciid":"328","login_name":"lychko_vv1","requester_allowed_to_view":null,"phone":"195","sip_user":null,"employee_id":null,"domain":{"canonical_name":"str.local","name":"STR.LOCAL","id":"1"},"name":"Лычко Владимир Витальевич","user_udf_fields":{"udf_pick_303":"АТР","udf_sline_302":"95","udf_sline_306":null},"enable_telephony":false,"status":"ACTIVE"},{"email_id":"nikolaev_ev@solid-tr.ru","extension":null,"description":"-","is_vipuser":false,"reporting_to":null,"type":"User","citype":{"name":"User","id":3},"cost_per_hour":"0.00","org_user_status":"ACTIVE","id":"236","department":{"site":{"name":"812 ИТ","id":"24"},"name":"Отдел информационных технологий","id":"364"},"first_name":"Евгений","created_time":{"display_value":"25-07-2023 16:20:34","value":"1690291234082"},"is_technician":false,"jobtitle":"Cпециалист","mobile":"+7 926 811 20 46","profile_pic":{"content-url":"/images/default-profile-pic2.svg"},"last_name":"Николаев","sms_mail_id":null,"middle_name":"Валерьевич","created_by":{"email_id":null,"phone":null,"name":"administrator","mobile":"1234567890","profile_pic":{"content-url":"/images/default-profile-pic2.svg"},"is_vipuser":false,"id":"5","department":{"site":{"name":"812 ИТ","id":"24"},"name":"Отдел информационных технологий","id":"364"}},"ciid":"332","login_name":"nikolaev_ev","requester_allowed_to_view":null,"phone":"194","sip_user":null,"employee_id":null,"domain":{"canonical_name":"str.local","name":"STR.LOCAL","id":"1"},"name":"Николаев Евгений Валерьевич","user_udf_fields":{"udf_pick_303":"АТР","udf_sline_302":"92","udf_sline_306":null},"enable_telephony":false,"status":"ACTIVE"},{"email_id":"esenov_ot@solid-tr.ru","extension":null,"description":"-","is_vipuser":true,"reporting_to":null,"type":"User","citype":{"name":"User","id":3},"cost_per_hour":"0.00","org_user_status":"ACTIVE","id":"242","department":{"site":{"name":"703 Коммерция","id":"7"},"name":"Администрация","id":"348"},"first_name":"Олег","created_time":{"display_value":"25-07-2023 16:20:36","value":"1690291236342"},"is_technician":false,"jobtitle":"Первый заместитель Генерального директора","mobile":"+7 916 750 70 00","profile_pic":{"content-url":"/images/default-profile-pic2.svg"},"last_name":"Есенов","sms_mail_id":null,"middle_name":"Таймуразович","created_by":{"email_id":null,"phone":null,"name":"administrator","mobile":"1234567890","profile_pic":{"content-url":"/images/default-profile-pic2.svg"},"is_vipuser":false,"id":"5","department":{"site":{"name":"812 ИТ","id":"24"},"name":"Отдел информационных технологий","id":"364"}},"ciid":"339","login_name":"esenov_ot","requester_allowed_to_view":null,"phone":"113","sip_user":null,"employee_id":null,"domain":{"canonical_name":"str.local","name":"STR.LOCAL","id":"1"},"name":"Есенов Олег Таймуразович","user_udf_fields":{"udf_pick_303":"СТР","udf_sline_302":"41","udf_sline_306":"WS-130"},"enable_telephony":false,"status":"ACTIVE"},{"email_id":"anton@solid-tr.ru","extension":null,"description":"-","is_vipuser":true,"reporting_to":null,"type":"User","citype":{"name":"User","id":3},"cost_per_hour":"0.00","org_user_status":"ACTIVE","id":"246","department":{"site":{"name":"703 Коммерция","id":"7"},"name":"Администрация","id":"348"},"first_name":"Антон","created_time":{"display_value":"25-07-2023 16:20:37","value":"1690291237827"},"is_technician":false,"jobtitle":"Коммерческий директор","mobile":"+7 916 346 07 64","profile_pic":{"content-url":"/images/default-profile-pic2.svg"},"last_name":"Разворотнев","sms_mail_id":null,"middle_name":"Александрович","created_by":{"email_id":null,"phone":null,"name":"administrator","mobile":"1234567890","profile_pic":{"content-url":"/images/default-profile-pic2.svg"},"is_vipuser":false,"id":"5","department":{"site":{"name":"812 ИТ","id":"24"},"name":"Отдел информационных технологий","id":"364"}},"ciid":"343","login_name":"anton","requester_allowed_to_view":null,"phone":"112","sip_user":null,"employee_id":null,"domain":{"canonical_name":"str.local","name":"STR.LOCAL","id":"1"},"name":"Разворотнев Антон Александрович","user_udf_fields":{"udf_pick_303":"СТР","udf_sline_302":"39","udf_sline_306":"WS-109,WS-163,WS-165"},"enable_telephony":false,"status":"ACTIVE"}]}',true);
        try
            {
            $data=$this->getData();
            if(!is_array($data)){throw new GoodException('Ошибка загрузки данных из helpdesk','Данные не являются массивом');}
            }
        catch (GoodException $exception)
            {
            throw $exception;
            }
        //echo count($data);
        return $this->render('index',compact('data'));
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
