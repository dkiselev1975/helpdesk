<?php
/** @var yii\web\View $this */
/** @var array $items */
/** @var string $empty_list_phrase */
/** @var object $users */

$this->title = Yii::$app->params['app_name']['backend'];
?><p><strong>Count: </strong><?var_dump (count($users->users));?></p><?

class showTree
{
    private $fields=array('name','jobtitle','phone','department');
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
                        'object_title'=>'object_title fw-bold bg-light',
                        'is_scalar_value'=>'main_value fw-normal col-12 col-sm-4 w-100',

                    ],
                1=>
                    [
                        'is_object'=>'secondary_object d-flex flex-wrap',
                        'object_title'=>'object_title fw-bold',
                        'is_scalar_value'=>'secondary_value fw-normal',
                    ],
            ],
    ];

    function get_value(string $key,mixed $value,string $section)
    {
        static $level=0;

        if(is_object($value))
        {
            $class=$this->classes[$section][(int)((bool)$level)]['is_object'];
            ?><div class="<?=$class;?> ps-<?=$level?>"><?
            ?><div class="<?=$this->classes[$section][(int)((bool)$level)]['object_title']?>" title="(is_obj),level: <?=$level;?>"><?=$key.":";?></div><?
            foreach ($value as $k=>$v)
            {
                $level++;
                $this->get_value($k,$v,$section);
                --$level;
            }
            ?></div><?
        }
        else
        {
            $class=$this->classes[$section][(int)((bool)$level)]['is_scalar_value'];
            ?><div class="<?=$class;?> ps-<?=$level?>" title="level: <?=$level;?>"><?=$key.": ".(is_null($value)?'<span class="text-secondary">Нет данных</span>':$value);?></div><?
        }
    }
    function makeTree($data)
    {
        if(count($data)>0)
        {
            ?><div class="tree_container border-light"><?php
            foreach ($data as $k=>$v)
            {
                ?><div class="item_container border p-2 my-4"><?
                //var_dump(array_diff($v,$this->fields));
                ?><div class="primary_fields_container w-100 fw-bolder d-flex flex-wrap pb-2 bg-light"><?
                foreach($this->fields as $key)
                {
                    if(property_exists($v,$key))
                    {
                        $this->get_value($key,$v->$key,'primary');
                    }
                }
                ?></div><?
                ?><div class="secondary_fields_container w-100 fw-normal d-flex flex-wrap pb-3 border-top"><?
                foreach ($v as $second_key=>$second_value)
                {
                    if(!in_array($second_key,$this->fields))
                    {
                        $this->get_value($second_key,$v->$second_key,'secondary');
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
$tree->makeTree($users->users);

?><pre><?php var_dump($users->users);?></pre><?php
?>