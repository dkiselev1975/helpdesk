<?php

namespace frontend\controllers;
use backend\controllers\GoodException;
use common\models\SiteUser;
use frontend\models\ContactForm;
use frontend\models\DislocationRequestFrom;
use frontend\models\ResendVerificationEmailForm;
use frontend\models\VerifyEmailForm;
use SoapClient;
use Yii;
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
                        'actions' => ['logout','index','request'],
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
     * @throws \SoapFault
     * @throws \backend\controllers\GoodException
     */
    public function actionRequest():string
    {
        /*$client = new SoapClient("http://185.200.240.207/solid/ws/ws1.1cws?wsdl",
            [
                'login'=>'solid-tr.ru',
                'password'=>'solid',
           ]);

        $functions=$client->__getFunctions();
        $types=$client->__getTypes();*/

        /*$response=$client->ArmingDismountingOfWagonsThreeParameters
            (
                [
                    'Authentication'=>
                    [
                        'Login'=>'solid-tr.ru',
                        'Password'=>'solid'
                    ],
                    'DataArmingDisarmingThreeParameters'=>
                        [
                            'Status'=>'Постановка','WagonNumber'=>'73124232','TrackingType'=>'Срочный'
                        ]
                ]
        );*/

        /*
       2 => 'struct ArmingDismountingOfWagonsThreeParameters {
         string Status;
         string WagonNumber;
         string TrackingType;
        }'
       */

        /*Yii::debug($functions);
        Yii::debug($types);
        Yii::debug($response);*/

        $request=new DislocationRequestFrom();

        if ($request->load(Yii::$app->request->post()))
            {
                if(!$request->validate()){throw new GoodException('Неправильные параметры запроса дислокации');}
                $client = new SoapClient("http://185.200.240.207/solid/ws/ws1.1cws?wsdl",
                    [
                        'login'=>'solid-tr.ru',
                        'password'=>'solid',
                    ]);

                $response=$client->ArmingDismountingOfWagonsThreeParameters
                (
                    [
                        'Authentication'=>
                            [
                                'Login'=>'solid-tr.ru',
                                'Password'=>'solid'
                            ],
                        'DataArmingDisarmingThreeParameters'=>
                            [
                                'Status'=>'Постановка','WagonNumber'=>$request->WagonNumber,'TrackingType'=>'Срочный'
                            ]
                    ]
                );

                //Yii::debug($response->return->Успешно);
                if(!$response->return->Успешно){throw new GoodException('Ошибка постановки запроса на дислокацию',"Ответ сервера дислокации: ".$response->return->Ответ);}
                $user=SiteUser::findOne(['id'=>Yii::$app->user->id]);
                $page_title="SOAP запрос";
                $message=implode("\n",['Ваш запрос срочной дислокации вагона <strong>№'.$request->WagonNumber.'</strong> успешно отправлен.','Пожалуйста, ожидайте результат по адресу Вашей электронной почты ('.$user->email.').']);
                return $this->render('RequestResult',compact('page_title','message'));
            }
        else
            {
                $page_title="Запрос срочной дислокации вагона";
                return $this->render('Request',compact('request','page_title'));
            }

    }

}
