<?php
return [
    'app_name'=>['backend'=>'CMS | Сервис срочной дислокации','frontend'=>'Сервис срочной дислокации «Солид – товарные рынки»'],
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
        ],
    'messages'=>
        [
            'errors'=>
                [
                    'rules'=>[
                        'username'=>['required'=>'Пожалуйста, заполните поле «Имя пользователя»'],
                        'password'=>['required'=>'Пожалуйста, заполните поле «Пароль»'],
                        'email'=>['required'=>'Пожалуйста, заполните поле «Email»'],
                        ],
                    'login_is_already_used'=>'Данное имя пользователя уже занято',/*This username has already been taken.*/
                    'email_is_already_used'=>'Данный адрес электронной почты уже занят',/*This email address has already been taken.*/
                    'validate_password'=>'Неправильное имя пользователя или пароль',/*'Incorrect username or password.'*/
                ]
            ,
            'signup_form'=>[
                'title'=>'Регистрация',
                'fields'=>['username'=>'Имя пользователя','email'=>'Email','password'=>'Пароль'],
                'buttons'=>['signup'=>'Зарегистрироваться'],
                'sub_title'=>'Пожалуйста, заполните следующие поля для регистрации',
            ],

            'login_form'=>[
                'title'=>'Вход в систему',
                'fields'=>['username'=>'Имя пользователя','password'=>'Пароль','rememberMe'=>'Запомнить меня'],
                'buttons'=>['signup'=>'Войти в систему'],
                'sub_title'=>'Пожалуйста, заполните следующие поля для входа',
                'texts'=>[
                    'forgot_password'=>[
                        'Если Вы забыли свой пароль, Вы можете ',
                        'сбросить его'
                    ],
                    'resend'=>[
                        'Требуется выслать новое проверочное письмо?',
                        'Выслать вновь'
                    ]
                ],
            ],
            'email'=>[
                'hello'=>'Здравствуйте, уважаемый(-ая)',/*Hello*/
                'verify_link'=>'Перейдите по ссылке для подтверждения Вашего адреса электронной почты',/*Follow the link below to verify your email*/
                'reset_password'=>'Перейдите по ссылке для сброса Вашего пароля',/*Follow the link below to reset your password*/
            ],
        ],
];