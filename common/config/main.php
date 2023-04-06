<?php
return [
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'components' => [
        'formatter' => [
            'defaultTimeZone' => 'Europe/Moscow',
            'timeZone' => 'Europe/Moscow',
            'currencyCode' => 'RUR',
            'decimalSeparator' => '.',
            'thousandSeparator' => ' ',
        ],

        'cache' => [
            'class' => \yii\caching\FileCache::class,
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            'viewPath' => '@common/mail',
            'useFileTransport' => false,
        ],
    ],
    'language'=>'ru-RU',
    'name'=>'Сервис срочной дислокации'
];
