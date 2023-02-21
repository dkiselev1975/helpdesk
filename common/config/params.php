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
    'timeZone'=>'Europe/Moscow',
    'regexp'=>
        [
            'date_format'=>'/^\d{2}\.\d{2}\.\d{4}\s\d{2}\:\d{2}$/',
            'phone_mobile'=>'/^(?:\+7|8)[\-\s]?\(?[0-9]{3}\)?[\-\s]?[0-9]{3}[\-\s]?[0-9]{2}[\-\s]?[0-9]{2}$/',/*номер в формате +7 916 777-85-88 или 8 916 7778588*/
            'phone_office'=>'/^(?:\+7|8)?[\-\s]?\(?[0-9]{3}\)?[\-\s]?[0-9]{3}[\-\s]?[0-9]{2}[\-\s]?[0-9]{2}(?:\+\d{1,5})?$/',/*Можно ввести без кода страны +7 или 8 с добавочным номером +1..+45842*/
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
                'unix_timestamp'=>'php:U',
            ]
        ],
    'messages'=>
        [
            'errors'=>
                [
                    'rules'=>[
                        'username'=>[
                            'required'=>'Пожалуйста, заполните поле «Имя пользователя»',/**/
                            'tooLong'=>'Длина данного поля должна быть не более 45 символов',/**/
                            'tooShort'=>'Длина данного поля должна быть не менее 2 символов',/**/
                        ],/**/
                        'password'=>['required'=>'Пожалуйста, заполните поле «Пароль»'],/**/
                        'email'=>[
                            'required'=>'Пожалуйста, заполните поле «Email»',/**/
                            'tooLong'=>'Длина данного поля должна быть не более 255 символов',/**/
                            ],
                        'phone'=>['pattern'=>'Неверный формат номера телефона'],
                        ],
                    'login_is_already_used'=>'Данное имя пользователя уже занято',/*This username has already been taken.*/
                    'email_is_already_used'=>'Данный адрес электронной почты уже занят',/*This email address has already been taken.*/
                    'validate_password'=>'Неправильное имя пользователя или пароль',/*'Incorrect username or password.'*/
                    'error_pages'=>[
                        'server_error'=>[
                            'Данная ошибка возникла во время обработки Вашего запроса веб-сервером',/*The above error occurred while the Web server was processing your request.*/
                            ['Пожалуйста, ','свяжитесь с нами',', если Вы считаете, что это программная ошибка. Спасибо'],/*Please contact us if you think this is a server error. Thank you.*/
                        ],
                    ],
                ]
            ,
            'navbar'=>[
                'Home'=>'Начальная страница',/*Home*/
                'Login'=>'Войти',/*Login*/
                'Logout'=>'Выйти',/*Logout*/
                'Signup'=>'Зарегистрироваться',/*Signup*/
                'About'=>'О системе',/*About*/
                'Contact'=>'Контакты',/*Contact*/
                ],
            'signup'=>[
                'page_title'=>'Регистрация',/*Signup*/
                'sub_title'=>'Пожалуйста, заполните следующие поля для регистрации',/*Please fill out the following fields to signup:*/
                'fields'=>[
                    'username'=>'Имя пользователя',/*username*/
                    'email'=>'Email',/*email*/
                    'password'=>'Пароль',/*password*/
                ],
                'buttons'=>['signup'=>'Зарегистрироваться'],/*signup*/
            ],

            /*frontend/controllers/SiteController.php*/
            'actionContact'=>[
                'success'=>'Благодарим Вас за обращение к нам. Мы ответим Вам как можно быстрее',/*Thank you for contacting us. We will respond to you as soon as possible*/
                'error'=>'К сожалению, при отправке Вашего сообщения произошла ошибка',/*There was an error sending your message*/
            ],
            'actionSignup'=>
                [
                    'success'=>'Благодарим Вас за регистрацию. Пожалуйста, проверьте свою почту для получения подтверждающего электронного письма',/*Thank you for registration. Please check your inbox for verification email*/
                ],
            'actionRequestPasswordReset'=>[
                'success'=>'Пожалуйста, проверьте свою почту для получения дальнейших указаний',/*Check your email for further instructions*/
                'error'=>'К сожалению, мы не можем сбросить Ваш пароль для введенного адреса электронной почты',/*Sorry, we are unable to reset password for the provided email address*/
            ],

            'actionResetPassword'=>[
                'success'=>'Новый пароль сохранен',/*New password saved*/
            ],
            'actionVerifyEmail'=>[
                'success'=>'Ваш адрес электронной почты подтвержден',/*'Your email has been confirmed'*/
                'error'=>'К сожалению, мы не можем подтвердить Вашу учетную запись введенным кодом',/*Sorry, we are unable to verify your account with provided token*/
            ],

            'actionResendVerificationEmail'=>[
                'success'=>'Пожалуйста, проверьте свою почту для получения дальнейших указаний',/*Check your email for further instructions*/
                'error'=>'К сожалению, мы не можем выслать подтверждающее письмо на введенный адрес электронной почты',/*'Sorry, we are unable to resend verification email for the provided email address*/
            ],

            /*views*/
            'login'=>[
                'page_title'=>'Вход в систему',/*Login*/
                'sub_title'=>'Пожалуйста, заполните следующие поля для входа',/*Please fill out the following fields to login*/
                'fields'=>[
                    'username'=>'Имя пользователя',/*username*/
                    'password'=>'Пароль',/*password*/
                    'rememberMe'=>'Запомнить меня',/*rememberMe*/
                ],
                'buttons'=>['login'=>'Войти в систему'],/*Login*/
                'texts'=>[
                    'forgot_password'=>[
                        'Если Вы забыли свой пароль, Вы можете ',/*If you forgot your password you can*/
                        'сбросить его',/*reset it*/
                    ],
                    'resend'=>[
                        'Требуется выслать новое проверочное письмо?',/*Need new verification email?*/
                        'Выслать вновь',/*Resend*/
                    ]
                ],
            ],
            'request_password_reset_token'=>[
                'page_title'=>'Запрос на сброс пароля',/*Request password reset*/
                'sub_title'=>'Заполните, пожалуйста, адрес своей электронной почты. Вам будет выслана ссылка на сброс пароля',/*Please fill out your email. A link to reset password will be sent there.*/
                'fields'=>['email'=>'Ваш email'],
                'buttons'=>[
                    'send'=>'Отправить'/*Send*/
                ],
            ],
            'resend_verification_email'=>[
                'page_title'=>'Выслать проверочное письмо',/*Resend verification email*/
                'sub_title'=>'Заполните, пожалуйста, адрес своей электронной почты. Вам будет выслано проверочное письмо',/*Please fill out your email. A verification email will be sent there*/
                'fields'=>['email'=>'Ваш email'],
                'buttons'=>[
                    'send'=>'Отправить'/*Send*/
                ],
            ],
            'reset_password'=>[
                'page_title'=>'Сброс пароля',/*Reset password*/
                'sub_title'=>'Пожалуйста, введите Ваш новый пароль',/*Please choose your new password*/
                'fields'=>['password'=>'Пароль'],/*password*/
                'buttons'=>[
                    'save'=>'Save'/*Save*/
                ],
            ],
            'email'=>[
                'hello'=>'Здравствуйте, уважаемый(-ая)',/*Hello*/
                'verify_link'=>'Перейдите по ссылке для подтверждения Вашего адреса электронной почты',/*Follow the link below to verify your email*/
                'reset_password'=>'Перейдите по ссылке для сброса Вашего пароля',/*Follow the link below to reset your password*/
            ],

            'send'=>'Отправить',/*Send*/
        ],
];