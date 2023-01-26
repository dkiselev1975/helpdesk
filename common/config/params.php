<?php
return [
    'app_name'=>['backend'=>'CMS сервиса срочной дислокации «Солид – товарные рынки»','frontend'=>'Сервис срочной дислокации «Солид – товарные рынки»'],
    'company_name'=>'«Солид – товарные рынки»',
    'company_name_full'=>'АО «Солид – товарные рынки»',
    'sending_title'=>'Сервис срочной дислокации АО «Солид – товарные рынки»',
    'adminEmail' => 'webmaster@solid-tr.ru',

    'supportEmail' => 'webmaster@solid-tr.ru',
    'senderEmail' => 'webmaster@solid-tr.ru',
    'senderName' => 'АО «Солид – товарные рынки»',

    'user.passwordResetTokenExpire' => 3600,
    'user.passwordMinLength' => 8,
    'timeZone'=>'UTC+10',
    'regexp'=>
        [
            'date_format'=>'/^\d{2}\.\d{2}\.\d{4}\s\d{2}\:\d{2}$/',
            'phone'=>'/^(?:\+7|8)[\-\s]?\(?[0-9]{3}\)?[\-\s]?[0-9]{3}[\-\s]?[0-9]{2}[\-\s]?[0-9]{2}$/',
        ],
    'emails'=>
        [
            'sending_from_email'=>'sending@solid-tr.ru',
            'site_from_email'=>'sending@solid-tr.ru',
            'notification_email'=>array('webmaster@solid-tr.ru'),
            'noReply_email' => 'no-reply@solid-tr.ru',
        ],

    'date_formats'=>
        [
            'icu'=>['index_news_dateFormat'=>'LLLL, y'],
            'php'=>[
                'MySQL_DATETIME_format'=>'php:Y-m-d H:i:s',
                'date_format'=>'php:d.m.Y',
                'date_time_format'=>'php:d.m.Y H:i',
            ]
        ]
];