<?php

namespace frontend\controllers;
use backend\controllers\GoodException;
use common\models\Request;
use common\models\SiteUser;
use ErrorException;
use Exception;
use frontend\models\ContactForm;
use frontend\models\DislocationRequestFrom;
use frontend\models\ResendVerificationEmailForm;
use frontend\models\VerifyEmailForm;
use SoapClient;
use SoapFault;
use stdClass;
use Yii;
use yii\base\BaseObject;
use yii\base\ExitException;
use yii\base\InvalidArgumentException;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\SiteLoginForm;
use frontend\models\PasswordResetRequestForm;
use frontend\models\ResetPasswordForm;
use frontend\models\SignupForm;
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
                            'request'
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
        $soap_request=new DislocationRequestFrom();
        if ($soap_request->load(Yii::$app->request->post()))
            {
            try
                {
                $request=new Request();
                $request['status']=0;
                $request['response']='SOAP запрос не выполнялся';
                $request['user_id']=Yii::$app->user->id;
                $request['wagon_number']=$soap_request->WagonNumber;

                if(!$soap_request->validate()){throw new GoodException('Неправильные параметры запроса дислокации');}
                if(YII_DEBUG){
                    //$soap_response=(object)array('return'=>(object)['Успешно'=>false,'Ответ'=>'this carriage/container is already added']);
                    $soap_response=(object)array('return'=>(object)
                        [
                            'Ответ'=>'',
                            'Успешно'=>true,
                            'ИДВагона'=>'a5c768dd-f1e2-44d7-8885-65be6b5ca834'
                        ],
                    );
                    }
                else
                    {
                    $client = new SoapClient(Yii::$app->params['DislocationSOAP']['url'],
                        [
                            'login'=>'solid-tr.ru',
                            'password'=>'solid',
                        ]);

                    $soap_response=$client->ArmingDismountingOfWagonsThreeParameters
                        (
                            [
                            'Authentication'=>
                                [
                                    'Login'=>'solid-tr.ru',
                                    'Password'=>'solid'
                                ],
                            'DataArmingDisarmingThreeParameters'=>
                                [
                                    'Status'=>'Постановка','WagonNumber'=>$soap_request->WagonNumber,'TrackingType'=>'Срочный'
                                ]
                            ]
                        );
                    }
                }
            /*Сервер не отвечает*/
            catch (SoapFault $error)
                    {
                    $errors[]=$error->getMessage();
                    $request['response']=$error->getMessage();
                    try
                        {
                        $request->save();
                        }
                    catch (ErrorException $error)
                        {
                        $errors[]='Ошибка записи информации о запросе';
                        }
                    throw new GoodException('Ошибка постановки запроса на дислокацию',implode(";\n",$errors).".",buttons: [['title'=>'Вернуться','href'=> Yii::$app->request->referrer]]);
                    }

            /*Обработка ответа сервера*/
            if(YII_DEBUG){Yii::debug($soap_response);}
            if(!$soap_response->return->Успешно){
                $message=match ($soap_response->return->Ответ)
                    {
                    'this carriage/container is already added'=>implode(' ',['Вагон',$soap_request->WagonNumber,'уже был поставлен на дислокацию']),
                    default=>$soap_response->return->Ответ,
                    };

                $errors[]=trim('<strong>'."Ответ сервера дислокации: ".'</strong>'.$message,'.');
                $request['response']=$message;
                try
                {
                    $request->validate();
                }
                catch (ErrorException $error)
                {
                    $errors[]='Ошибка записи информации о запросе';
                }
                throw new GoodException('Ошибка постановки запроса на дислокацию',implode(";\n",$errors).".",buttons: [['title'=>'Вернуться','href'=> Yii::$app->request->referrer]],parse_html:false);
                }

            $user=SiteUser::findOne(['id'=>Yii::$app->user->id]);
            $page_title="SOAP запрос";
            $messages[]=implode("\n",['Ваш запрос срочной дислокации вагона <strong>№'.$soap_request->WagonNumber.'</strong> успешно отправлен.','Пожалуйста, ожидайте результат по адресу Вашей электронной почты ('.$user->email.').']);
            $request['status']=1;
            try
            {
                $request->save();
            }
            catch (ErrorException)
            {
                $messages[]='Ошибка записи информации о запросе';
            }

            $message="<p>".implode("</p>\n<p>",$messages)."</p>";
            return $this->render('RequestResult',compact('page_title','message'));
            }
        else
            {
            $page_title="Запрос срочной дислокации вагона";
            return $this->render('RequestForm',compact('page_title','soap_request'));
            }
    }

}
