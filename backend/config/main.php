<?php
$params = array_merge(
    require __DIR__ . '/../../common/config/params.php',
    require __DIR__ . '/../../common/config/params-local.php',
    require __DIR__ . '/params.php',
    require __DIR__ . '/params-local.php'
);

return [
    'id' => 'app-backend',
    'basePath' => dirname(__DIR__),
    'controllerNamespace' => 'backend\controllers',
    'bootstrap' => ['log'],
    'modules' => [
        'debug' => [
            'class' => 'yii\debug\Module',
            'allowedIPs' => ['172.20.1.205']
        ],
    ],
    'components' => [
        'request' => [
            'csrfParam' => '_csrf-backend',
        ],
        'user' => [
            'identityClass' => 'common\models\AdminUser',
            'enableAutoLogin' => true,
            'identityCookie' => ['name' => '_identity-backend', 'httpOnly' => true],
        ],
        'session' => [
            // this is the name of the session cookie used for login on the backend
            'name' => 'advanced-backend',
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
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],

        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'enableStrictParsing' => true,
            'rules' => [
                'site/login'=>'site/login',
                'admin/logout'=>'admin/logout',
                ''=>'admin/index',
                'index'=>'admin/index',

                'site-user-index' =>'admin/site-user-index',
                'site-user-edit-form' => 'admin/site-user-edit-form',
                'site-user-edit-form/<id:\d+>' => 'admin/site-user-edit-form',
                'site-user-delete/<id:\d+>' => 'admin/site-user-delete',

                'company-index' =>'admin/company-index',
                'company-edit-form' =>'admin/company-edit-form',
                'company-edit-form/<id:\d+>' => 'admin/company-edit-form',
                'company-delete/<id:\d+>' => 'admin/company-delete',
                'request-index'=>'admin/request-index',
            ],
        ],

    ],
    'params' => $params,
];
