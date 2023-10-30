<?php
return [
    'regexp'=>
        [
            'date_format'=>'/^\d{2}\.\d{2}\.\d{4}\s\d{2}\:\d{2}$/',
            'phone_mobile'=>'/^(?:\+7|8)[\-\s]?\(?[0-9]{3}\)?[\-\s]?[0-9]{3}[\-\s]?[0-9]{2}[\-\s]?[0-9]{2}$/',/*номер в формате +7 916 777-85-88 или 8 916 7778588*/
            'phone_office'=>'/^(?:\+7|8)?[\-\s]?\(?[0-9]{3}\)?[\-\s]?[0-9]{3}[\-\s]?[0-9]{2}[\-\s]?[0-9]{2}(?:\+\d{1,5})?$/',/*Можно ввести без кода страны +7 или 8 с добавочным номером +1..+45842*/
            'price_of_request'=>'/^\d{1,4}(?:[\.,]\d{2})?$/',
        ],
];