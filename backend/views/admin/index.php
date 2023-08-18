<?php
/** @var yii\web\View $this */
/** @var array $items */
/** @var string $empty_list_phrase */
/** @var object $users */

$this->title = Yii::$app->params['app_name']['backend'];
?><p><strong>Count: </strong><?var_dump (count($users['users']));?></p><?

class showTree
{
    private array $fields=['name','email_id','jobtitle','mobile','department'];
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
    //"first_name"=>"Имя",
    "jobtitle"=> "Должность",
    "mobile"=>"Моб. телефон",
    //"last_name"=>"Фамилия",
    "sms_mail_id"=>'Адрес SMS-почты',
    //"middle_name"=>"Отчество",
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
    /*"created_by"=>[
            "name"=>"Кем создано",
            "department"=>
                [
                "name"=>"Подразделение",
                "site"=>["name"=>"Комната"]
                ]
            ]*/
  ];
    private array $classes=
    [
        'general_container'=>'tree_container border-light',
        'primary_header_box'=>'item_container border p-2 my-4',

        'primary_container'=>'primary_fields_container w-100 fw-bolder d-flex flex-wrap pb-2 bg-light justify-content-center',
        'primary'=>
            [
                0=>
                    [
                        //'is_object'=>'main_object d-flex flex-wrap',
                        //'object_title'=>'object_title fw-bold bg-light',
                        'is_scalar_value'=>'main_value px-2 fw-bold col-12 col-sm-6 text-center',
                    ],
                1=>
                    [
                        //'is_object'=>'secondary_object d-flex flex-wrap',
                        //'object_title'=>'object_title fw-bold',
                        'is_scalar_value'=>'secondary_value fw-normal px-2 col-12 col-sm-6 text-center fw-bold',
                    ],
            ],
        'secondary_container'=>'secondary_fields_container w-100 fw-normal d-flex flex-wrap pb-3 border-top',
        'secondary'=>
            [
                0=>
                    [
                        //'is_object'=>'main_object d-flex flex-wrap',
                        //'object_title'=>'object_title',
                        'is_scalar_value'=>'main_value fw-normal col-12 col-sm-4 p-2',

                    ],
                1=>
                    [
                        //'is_object'=>'secondary_object d-flex flex-wrap w-100',
                        //'object_title'=>'object_title fw-bold bg-secondary w-100',
                        'is_scalar_value'=>'secondary_value fw-normal col-12 col-sm-4 p-2',
                    ],
            ],
    ];

    private function getEmptyValueText():string
    {
    return '<span class="text-secondary">Нет данных</span>';
    }

    private function get_empty_titles(mixed $translate,bool $init=false):string
        {
        static $title=[];
        if($init){$title=[];}
        if(is_string($translate)){
            $title[0]=$translate.": ".$this->getEmptyValueText();
            }
        else
            {
                $title=[];
                foreach ($translate as $translate_title)
                {
                    if(is_array($translate_title)){
                        $this->get_empty_titles($translate_title);
                    }
                    else{
                        $title[]=$translate_title.": ".$this->getEmptyValueText();
                    }
                }
            }
        return implode(' ',$title);
        }

    private function get_value(string $key,mixed $value,string $section,$translate,bool $flat=true)
    {
        static $level=0;
        if(is_array($value))
        {
        if(!$flat)
            {
            $class=$this->classes[$section][(int)((bool)$level)]['is_object'];
            if(!$flat){$class.=$class." ps-".$level;}
            ?><div class="<?=$class;?>"><?
            ?><div class="<?=$this->classes[$section][(int)((bool)$level)]['object_title']?>" title="(is_obj),level: <?=$level;?>"><?=$key.":";?></div><?
            }
            foreach ($value as $k=>$v)
            {
                $level++;
                if(isset($translate[$k])){$this->get_value($k,$v,$section,$translate[$k]);}
                --$level;
            }
        if(!$flat)
            {
            ?></div><?
            }
        }
        else{
            //var_dump($translate);
            if(is_null($value))
                {
                $title=$this->get_empty_titles($translate,true);
                }
            else
                {
                if(is_bool($value))
                    {
                        $value=($value)?'Да':'Нет';
                    }
                $title=$translate.": ".$value;
                }
            //if(is_string($translate)){$title=$translate;}else{var_dump($translate,$value);echo gettype($translate);}
            $class=$this->classes[$section][(int)((bool)$level)]['is_scalar_value'];
            if(!$flat){$class.=$class." ps-".$level;}
            ?><div class="<?=$class;?>" title="level: <?=$level."(".$key.")";?>"><?=$title;?></div><?
        }
    }

    public function makeTree($data)
    {
        if(count($data)>0)
        {
            ?><div class="<?=$this->classes['general_container'];?>"><?php
            foreach ($data as $value)
            {
                ?><div class="<?=$this->classes['primary_header_box'];?>"><?
                //var_dump(array_diff($v,$this->fields));
                ?><div class="<?=$this->classes['primary_container'];?>"><?
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
                ?><div class="<?=$this->classes['secondary_container'];?>"><?

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