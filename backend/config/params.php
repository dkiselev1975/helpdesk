<?php
return [
    'left_menu'=>
        [
            ['label' => 'Начальная', 'url' => 'index', 'class' =>'fw-bold mb-2'],
            ['label' => 'Пользователи', 'url' => 'site-user-index', 'class' =>'fw-bold mb-2'],
            /*['label' => 'Добавить', 'url' => 'site-user-edit-form', 'class' =>'mb-2'],*/
            ['label' => 'Запросы', 'url' => 'request-index', 'class' =>'fw-bold mb-2'],

            ['label' => 'Компании', 'url' => 'company-index', 'class' =>'fw-bold'],
            ['label' => 'Добавить', 'url' => 'company-edit-form', 'class' =>'mb-2'],

            ['label' => 'Страны и тарифы', 'url' => 'country-index', 'class' =>'fw-bold'],
            ['label' => 'Добавить', 'url' => 'country-edit-form', 'class' =>'mb-2'],

        ],
];
