<?php

namespace frontend\controllers;
use backend\controllers\GoodException;
use common\models\Request;
use common\models\SiteUser;
use common\models\DislocationRequestFrom;
use ErrorException;
use frontend\models\ContactForm;
use SoapClient;
use SoapFault;
use Yii;
use yii\helpers\Html;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
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
                            'request',
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
            'captcha' => [
                'class' => \yii\captcha\CaptchaAction::class,
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex():string
    {
        return $this->render('index');
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
     * @throws \backend\controllers\GoodException
     */
    public function actionRequest():string
    {
        define('send_request',true) ;
        $user=SiteUser::findOne(['id'=>Yii::$app->user->id]);
        $soap_request=new DislocationRequestFrom();
        if ($soap_request->load(Yii::$app->request->post()))
            {
            try
                {
                $request=new Request();
                $request['user_id']=Yii::$app->user->id;
                $request['wagon_number']=$soap_request->WagonNumber;
                $request['user_email']=$user->email;/*email получателя результатов дислокации*/
                $request['debug_flag']=(int)(!send_request);
                if(!$soap_request->validate()){throw new GoodException('Неправильные параметры запроса дислокации');}
                if(send_request)
                    {
                    $client = new SoapClient(Yii::$app->params['DislocationSOAP']['url'],
                        [
                            'login' => 'solid-tr.ru',
                            'password' => 'solid',
                        ]);

                    $soap_response=$client->ArmingDismountingOfWagonsThreeParameters(
                            [
                                'Authentication' =>
                                    [
                                        'Login' => 'solid-tr.ru',
                                        'Password' => 'solid'
                                    ],
                                'DataArmingDisarmingThreeParameters' =>
                                    [
                                        'Status' => 'Постановка', 'WagonNumber' => $soap_request->WagonNumber, 'TrackingType' => 'Срочный', 'Mail' => $user->email
                                    ]
                            ]
                            );
                        }
                else
                    {
                    $soap_response=(object)array('return'=>(object)['Успешно'=>false,'Ответ'=>'this carriage/container is already added']);
                    //$soap_response = (object)array('return' => (object)['Ответ' => 'Тестовый ответ','Успешно' => true,'ИДВагона' => 'a5c768dd-f1e2-44d7-8885-65be6b5ca834'],);
                    }
                }
            /*Сервер не отвечает*/
            catch (SoapFault $error)
                    {
                    $errors[]='<strong>SoapFault: </strong>'.Html::encode(trim($error->getMessage()));
                    $request['repeated_flag']=null;
                    $request['response_success']=0;
                    $request['response_answer']=$error->getMessage();
                    try
                        {
                        //$request['response_success']='test';
                        $request->save();
                        }
                    catch (ErrorException $error)
                        {
                        $log_message=$errors[]='<strong>'.'Ошибка записи информации о запросе: '.'</strong>'.$error->getMessage();
                        Yii::error(strip_tags($log_message));
                        }
                    throw new GoodException('Ошибка постановки запроса на дислокацию',implode(";\n",$errors).".",buttons: [['title'=>'Вернуться','href'=> Yii::$app->request->referrer]]);
                    }

            /*Обработка ответа сервера*/
            $request['repeated_flag']=match ($soap_response->return->Ответ)
            {
                'this carriage/container is already added','Вагон уже стоит на слежении!'=>true,
                default=>false,
            };

            if((!$soap_response->return->Успешно)||$request['repeated_flag']){
                $message=($request['repeated_flag'])?implode(' ',['Вагон',$soap_request->WagonNumber,'уже был поставлен на дислокацию']):$soap_response->return->Ответ;
                $errors[]=trim('<strong>'."Ответ сервера дислокации: ".'</strong>'.$message,'.!');
                $request['response_success']=(int)$soap_response->return->Успешно;
                $request['response_answer']=$soap_response->return->Ответ;
                try
                    {
                    //$request['response_success']='test';
                    $request->save();
                    }
                catch (ErrorException $error)
                    {
                    $log_message=$errors[]='<strong>'.'Ошибка записи информации о запросе: '.'</strong>'.$error->getMessage();
                    Yii::error(strip_tags($log_message));
                    }
                throw new GoodException('Ошибка постановки запроса на дислокацию',implode(";<br>",$errors).".",buttons: [['title'=>'Вернуться','href'=> Yii::$app->request->referrer]]);
                }
            $page_title="SOAP запрос";
            $result=implode("\n",['Ваш запрос срочной дислокации вагона <strong>№'.$soap_request->WagonNumber.'</strong> успешно отправлен.','Пожалуйста, ожидайте результат по адресу Вашей электронной почты ('.$user->email.').']);
            $messages[]=$result;
            $request['response_success']=(int)$soap_response->return->Успешно;
            $request['response_answer']=$soap_response->return->Ответ;
            try
                {
                //$request['response_success']='test';
                $request->save();
                }
            catch (ErrorException $error)
                {
                $log_message=$errors[]='<strong>'.'Ошибка записи информации о запросе: '.'</strong>'.$error->getMessage();
                Yii::error(strip_tags($log_message));
                }
            $message="<p>".implode("</p>\n<p>",$messages)."</p>";
            $error=(!empty($errors))?'<p class="text-danger">'.implode('\n',$errors).'.</p>':null;
            return $this->render('RequestResult',compact('page_title','message','error'));
            }
        else
            {
            $page_title="Запрос срочной дислокации вагона";
            return $this->render('RequestForm',compact('page_title','soap_request'));
            }
    }

    public function actionRequestIndex():string
    {
        $page_title='Мои запросы';
        $empty_list_phrase='Список запросов пуст';
        //$user=SiteUser::findOne(Yii::$app->user->id);
        /*$items=$user->getCompany()->orderBy(['id'=>SORT_DESC])->all();*/
        $items=Request::find()->where(['user_id'=>Yii::$app->user->id])->orderBy(['updated_at'=>SORT_DESC])->all();;
        return $this->render('RequestIndex',compact('page_title','empty_list_phrase','items'));
    }
}
