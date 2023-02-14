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
                'site-user-query-index' =>'admin/site-user-query-index',
                'site-user-query-edit-form' => 'admin/site-user-query-edit-form',
                'site-user-query-edit-form/<id:\d+>' => 'admin/site-user-query-edit-form',
                'site-user-query-delete/<id:\d+>' => 'admin/site-user-query-delete',
                'site-user-query-update' => 'admin/site-user-query-update',
            ],
        ],

    ],
    'params' => $params,
];
