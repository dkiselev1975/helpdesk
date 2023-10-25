<?php
return [
    'api_system_name'=>'Helpdesk',
    'company_name'=>'«Солид – товарные рынки»',
    'company_name_full'=>'АО «Солид – товарные рынки»',
    'sending_title'=>'Сервис Helpdesk АО «Солид – товарные рынки»',
    'adminEmail' => 'webmaster@solid-tr.ru',

    'supportEmail' => 'webmaster@solid-tr.ru',
    'senderEmail' => 'webmaster@solid-tr.ru',
    'senderName' => 'АО «Солид – товарные рынки»',

    'user.passwordResetTokenExpire' => 3600,
    'user.passwordMinLength' => 8,
    'timeZone'=>'Europe/Moscow',
    'currencyDecimalPlaces' => 2,
    'currencyName' => 'pуб.',
    'currencyShortName' => 'p.',
    'emails'=>
        [
            'sending_from_email'=>'sending@solid-tr.ru',
            'site_from_email'=>'sending@solid-tr.ru',
            'notification_email'=>array('webmaster@solid-tr.ru'),
            'noReply_email' => 'no-reply@solid-tr.ru',
        ],
    'defaultGoodExceptionLayout'=>'main',
    'defaultGoodExceptionAjaxLayout'=>'ajax',
    'DislocationSOAP'=>[
        'url'=>'https://server2.vagony.su/solid/ws/ws1.1cws?wsdl',
    ],
];