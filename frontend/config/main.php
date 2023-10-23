<?php
$params = array_merge(
    require __DIR__ . '/../../common/config/params.php',
    require __DIR__ . '/../../common/config/params-local.php',
    require __DIR__ . '/params.php',
    require __DIR__ . '/params-local.php'
);

return [
    'id' => 'app-frontend',
    'basePath' => dirname(__DIR__),
    /*'bootstrap' => ['log'],*/
   /* 'bootstrap' => ['log','debug'],*/
    'controllerNamespace' => 'frontend\controllers',
    'modules' => [
        'debug' => [
            'class' => 'yii\debug\Module',
            /*'allowedIPs' => ['172.20.1.205']*/
        ],
    ],
    /*'controllerMap' =>
        [
            'site' => 'frontend\controllers\SiteController',
            'frontend' => 'frontend\controllers\FrontendController',
        ],*/
    'components' => [
        'request' => [
            'csrfParam' => '_csrf-frontend',
        ],
        'user' => [
            'identityClass' => 'common\models\SiteUser',
            'enableAutoLogin' => true,
            'identityCookie' => ['name' => '_identity-frontend', 'httpOnly' => true],
        ],
        'session' => [
            // this is the name of the session cookie used for login on the frontend
            'name' => 'advanced-frontend',
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\DbTarget',
                    'levels' => ['error', 'warning','trace'],
                    'logTable' => 'yii_log'
                ]
            ],
        ],
        /*'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => \yii\log\FileTarget::class,
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],*/

        /*При возникновении ошибки сайта будет вызван адрес:*/
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],

        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'enableStrictParsing' => true,
            'rules' => [
                ''=>'frontend/index',
                'index'=>'frontend/index',
                'site/login'=>'site/login',
                'admin/logout'=>'frontend/logout',/*because admin template is used */
                'frontend/logout'=>'frontend/logout',

                'apiGetUsersData'=>'frontend/api-get-users-data',

                'site/signup'=>'site/signup',
                'site/request-password-reset'=>'site/request-password-reset',
                'site/resend-verification-email'=>'site/resend-verification-email',
                'site/reset-password'=>'site/reset-password',
                'site/verify-email'=>'site/verify-email',
            ],
        ],

    ],
    'params' => $params,
];
