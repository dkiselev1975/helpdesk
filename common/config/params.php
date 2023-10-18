<?php
return [
    'app_name'=>['backend'=>'CMS | Сервис Helpdesk','frontend'=>'Сервис Helpdesk «Солид – товарные рынки»'],
    'app_name_short'=>['backend'=>'CMS | Helpdesk','frontend'=>'Helpdesk «СТР»'],
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
    'regexp'=>
        [
            'date_format'=>'/^\d{2}\.\d{2}\.\d{4}\s\d{2}\:\d{2}$/',
            'phone_mobile'=>'/^(?:\+7|8)[\-\s]?\(?[0-9]{3}\)?[\-\s]?[0-9]{3}[\-\s]?[0-9]{2}[\-\s]?[0-9]{2}$/',/*номер в формате +7 916 777-85-88 или 8 916 7778588*/
            'phone_office'=>'/^(?:\+7|8)?[\-\s]?\(?[0-9]{3}\)?[\-\s]?[0-9]{3}[\-\s]?[0-9]{2}[\-\s]?[0-9]{2}(?:\+\d{1,5})?$/',/*Можно ввести без кода страны +7 или 8 с добавочным номером +1..+45842*/
            'price_of_request'=>'/^\d{1,4}(?:[\.,]\d{2})?$/',
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
    'defaultGoodExceptionLayout'=>'main',
    'defaultGoodExceptionAjaxLayout'=>'ajax',
    'DislocationSOAP'=>[
        'url'=>'https://server2.vagony.su/solid/ws/ws1.1cws?wsdl',
    ],
    'messages'=>
        [
            'emails'=>[
                'robot'=>'(автоматическая рассылка)',
                ],
            'errors'=>
                [
                    'rules'=>[
                        'name'=>['required'=>'Пожалуйста, заполните поле «Наименование»'],
                        'username'=>[
                            'required'=>'Пожалуйста, заполните поле «Логин»',/**/
                        ],/**/

                        'person_name'=>[
                            'required'=>'Пожалуйста, заполните поле «Имя пользователя»',/**/
                        ],/**/

                        'person_surname'=>[
                            'required'=>'Пожалуйста, заполните поле «Фамилия»',/**/
                        ],/**/

                        'password'=>['required'=>'Пожалуйста, заполните поле «Пароль»'],/**/
                        'email'=>[
                            'required'=>'Пожалуйста, заполните поле «Email»',/**/
                            'no_user'=>'Пользователя с данным адресом электронной почты не существует',/*'There is no user with this email address'*/
                            ],
                        'status'=>['required'=>'Пожалуйста, заполните поле "Статус"'],
                        'company_id'=>['required'=>'Пожалуйста, заполните поле "Компания"'],
                        'country_id'=>['required'=>'Пожалуйста, заполните поле "Страна"'],
                        'sizes'=>[
                            'tooLong'=>
                                [
                                    '64kb'=>'Длина данного поля должна быть не более 64кБ',
                                    '45smb'=>'Длина данного поля должна быть не более 45 символов',
                                    '255smb'=>'Длина данного поля должна быть не более 255 символов',
                                ],
                            'tooShort'=>['2smb'=>'Длина данного поля должна быть не менее 2 символов'],
                            ],
                        'format'=>'Неверный формат поля',
                        ],
                    'login_is_already_used'=>'Данное имя пользователя уже занято',/*This username has already been taken.*/
                    'email_is_already_used'=>'Данный адрес электронной почты уже занят',/*This email address has already been taken.*/
                    'unique_name'=>'Данное название уже используется',/*This email address has already been taken.*/
                    'validate_password'=>'Неправильное имя пользователя или пароль',/*'Incorrect username or password.'*/
                    'error_pages'=>[
                        'server_error'=>[
                            'Данная ошибка возникла во время обработки Вашего запроса веб-сервером',/*The above error occurred while the Web server was processing your request.*/
                            ['Пожалуйста, ','свяжитесь с нами',', если Вы считаете, что это программная ошибка. Спасибо'],/*Please contact us if you think this is a server error. Thank you.*/
                            'Перейти на начальную страницу',
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
                    'username'=>'Логин',/*username*/
                    'person_name'=>'Имя',
                    'person_patronymic'=>'Отчество',
                    'person_surname'=>'Фамилия',
                    'email'=>'Email',/*email*/
                    'password'=>'Пароль',/*password*/
                    'phone_office'=>'Телефон раб.',
                    'phone_mobile'=>'Телефон моб.',
                    'company_id'=>['prompt'=>'Выберите компанию','label'=>'Компания'],
                    'status'=>['prompt'=>'Выберите статус','label'=>'Статус'],
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

            /*frontend/models*/
            /*frontend/models/ContactForm.php*/
            'ContactForm'=>['verifyCode'=>'Код подтверждения'],/*Verification Code*/

            /*frontend/models/RequestForm.php*/
            'RequestForm'=>[
                'rules'=>['WagonNumber'=>[
                    'required'=>'Пожалуйста, заполните номер вагона',
                    'integer'=>'Номер вагона должен быть целым числом',
                    'format'=>'Номер вагона должен состоять из восьми цифр',
                    ]
                ],
                'fields'=>['WagonNumber'=>'Номер вагона','country_id'=>['prompt'=>'Выберите страну','label'=>'Страна']],
                'buttons'=>['submit'=>'Отправить запрос']
            ],

            /*frontend/models/PasswordResetRequestForm.php*/
            'PasswordResetRequestForm'=>[
                'password_reset_for'=>'Сброс пароля для ресурса',/*Password reset for*/
            ],

            /*frontend/models/ResendVerificationEmailForm.php*/
            'ResendVerificationEmailForm'=>[
                'account_registration_at'=>'Ваша учетная запись',/*Account registration at*/
            ],

            /*frontend/models/ResetPasswordForm.php*/
            'ResetPasswordForm'=>[
                'blank_token'=>'Код сброса пароля не может быть пустым',/*Password reset token cannot be blank*/
                'wrong_token'=>'Неверный код сброса пароля',/*Wrong password reset token*/
            ],

            /*frontend/models/SignupForm.php*/
            'SignupForm'=>[
                'account_registration_at'=>'Учетная запись зарегистрирована для',/*Account registration at*/
            ],

            /*frontend/models/VerifyEmailForm.php*/
            'VerifyEmailForm'=>[
                'blank_token'=>'Код в проверочном письме не может быть пустым',/*Verify email token cannot be blank*/
                'wrong_token'=>'Неверный код проверочного письма',/*Wrong verify email token*/
            ],

            /*views*/
            'login'=>[
                'page_title'=>'Вход в систему',/*Login*/
                'sub_title'=>'Пожалуйста, заполните следующие поля для входа',/*Please fill out the following fields to login*/
                'fields'=>[
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
                    ],
                    'signup'=>[
                        'Зарегистрироваться',/*Signup*/
                    ],
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
                'page_title'=>'Повторная отправка проверочного письма',/*Resend verification email*/
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
                    'save'=>'Сохранить'/*Save*/
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