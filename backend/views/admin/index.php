<?php
/** @var yii\web\View $this */
/** @var array $items */
/** @var string $empty_list_phrase */
/** @var object $users */

$this->title = Yii::$app->params['app_name']['backend'];
?><p><strong>Count: </strong><?var_dump (count($users['users']));?></p><?

class showTree
{
    private array $fields=['name','jobtitle','phone','department'];
    /*ID сотрудника*/
    /*Описание*/
    /*Дополнительные адреса эл. почты*/
    /*В подчинении у*/
    /*Автор заявки может просматривать*/
    /*Назначенные роли*/

    private array $translate=[
    "email_id"=>"Основной адрес эл. почты",
    "is_vipuser"=>"VIP-пользователь",
    "cost_per_hour"=>"Стоимость в час (RUB)",
    "department"=>[
        "site"=>
            [
            "name"=>"Название отдела"
            ]
    ],
    "first_name"=>"Имя",
    "jobtitle"=> "Должность",
    "mobile"=>"Моб. телефон",
    "last_name"=>"Фамилия",
    "sms_mail_id"=>'Адрес SMS-почты',
    "middle_name"=>"Отчество",
    "login_name"=> "Регистрационное имя",
    "phone"=>"Телефон",
    "domain"=>[
        "name"=>"Имя домена",
        ],
    "name"=>"Имя/название",
    "user_udf_fields"=>[
        "udf_pick_303"=>"Компания",
        "udf_sline_302"=>"Рабочее место",
        "udf_sline_306"=>"Имя компьютера",
    ],
  ];
    private array $classes=
    [
        'primary'=>
            [
                0=>
                    [
                        'is_object'=>'main_object d-flex flex-wrap',
                        'object_title'=>'object_title fw-bold bg-light',
                        'is_scalar_value'=>'main_value fw-normal col-auto px-2 fw-bold',

                    ],
                1=>
                    [
                        'is_object'=>'secondary_object d-flex flex-wrap',
                        'object_title'=>'object_title fw-bold',
                        'is_scalar_value'=>'secondary_value fw-normal',
                    ],
            ],
        'secondary'=>
            [
                0=>
                    [
                        'is_object'=>'main_object d-flex flex-wrap',
                        'object_title'=>'object_title',
                        'is_scalar_value'=>'main_value fw-normal col-12 col-sm-4 w-100',

                    ],
                1=>
                    [
                        'is_object'=>'secondary_object d-flex flex-wrap',
                        'object_title'=>'object_title fw-bold bg-secondary',
                        'is_scalar_value'=>'secondary_value fw-normal',
                    ],
            ],
    ];

    private function get_empty_titles(mixed $translate)
        {
        //var_dump($translate);
        static $title=[];
        if(is_string($translate)){
            $title[0]=$translate.": ".'<span class="text-secondary">Нет данных</span>';
            }
        else
            {
                foreach ($translate as $translate_title)
                {
                    if(is_array($translate_title)){
                        $this->get_empty_titles($translate_title);
                    }
                    else{
                        $title[]=$translate_title.": ".'<span class="text-secondary">Нет данных</span>';
                    }
                }
            }
        return implode(' ',$title);
        }

    private function get_value(string $key,mixed $value,string $section,$translate)
    {
        static $level=0;
        if(is_array($value))
        {
            $class=$this->classes[$section][(int)((bool)$level)]['is_object'];
            ?><div class="<?=$class;?> ps-<?=$level?>"><?
            ?><div class="<?=$this->classes[$section][(int)((bool)$level)]['object_title']?>" title="(is_obj),level: <?=$level;?>"><?=$key.":";?></div><?
            foreach ($value as $k=>$v)
            {
                $level++;
                if(isset($translate[$k])){$this->get_value($k,$v,$section,$translate[$k]);}
                --$level;
            }
            ?></div><?
        }
        else
        {
            //var_dump($translate);
            if(is_null($value))
                {
                $title=$this->get_empty_titles($translate);
                }
            else
                {
                $title=$translate.": ".$value;
                }
            //if(is_string($translate)){$title=$translate;}else{var_dump($translate,$value);echo gettype($translate);}
            $class=$this->classes[$section][(int)((bool)$level)]['is_scalar_value'];
            ?><div class="<?=$class;?> ps-<?=$level?>" title="level: <?=$level."(".$key.")";?>"><?=$title;?></div><?
        }
    }

    public function makeTree($data)
    {
        if(count($data)>0)
        {
            ?><div class="tree_container border-light"><?php
            foreach ($data as $value)
            {
                ?><div class="item_container border p-2 my-4"><?
                //var_dump(array_diff($v,$this->fields));
                ?><div class="primary_fields_container w-100 fw-bolder d-flex flex-wrap pb-2 bg-light"><?
                foreach($this->fields as $key)
                {
                    if(
                        (array_key_exists($key,$value))//есть данные из полей-заголовков в данных
                        &&
                        (array_key_exists($key,$this->translate))//есть перевод для поля заголовка
                    )
                    {
                        $this->get_value($key,$value[$key],'primary',$this->translate[$key]);
                    }
                }
                ?></div><?
                ?><div class="secondary_fields_container w-100 fw-normal d-flex flex-wrap pb-3 border-top"><?

                //var_dump($value);
                foreach ($value as $key=>$second_value)
                {

                    if(
                        (!in_array($key,$this->fields))//поле не выводилось в заголовок
                        &&
                        (array_key_exists($key,$this->translate))//есть перевод для поля
                    )
                    {
                        $this->get_value($key,$second_value,'secondary',$this->translate[$key]);
                    }
                }
                ?></div><?
                ?></div><?
            }
            ?></div><?php
        }
    }
}

$tree=new showTree();
//$tree->add_translate($users->users);
$tree->makeTree($users['users']);

?><pre><?php var_dump($users['users']);?></pre><?php
?>