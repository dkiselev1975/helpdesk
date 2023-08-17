<?php
/** @var yii\web\View $this */
/** @var array $items */
/** @var string $empty_list_phrase */
/** @var object $users */

$this->title = Yii::$app->params['app_name']['backend'];
?><p><strong>Count: </strong><?var_dump (count($users->users));?></p><?

$level=0;
$fields=array('name','jobtitle','phone','department');

function get_value(string $key,mixed $value,string $section,int &$level)
    {
    $classes=array(
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
    );
    if(is_object($value))
        {
        $class=$classes[$section][(int)((bool)$level)]['is_object'];
        ?><div class="<?=$class;?> ps-<?=$level?>"><?
        ?><div class="<?=$classes[$section][(int)((bool)$level)]['object_title']?>" title="(is_obj),level: <?=$level;?>"><?=$key.":";?></div><?
        foreach ($value as $k=>$v)
            {
            $level++;
            get_value($k,$v,$section,$level);
            --$level;
            }
        ?></div><?
        }
    else
        {
        $class=$classes[$section][(int)((bool)$level)]['is_scalar_value'];
        ?><div class="<?=$class;?> ps-<?=$level?>" title="level: <?=$level;?>"><?=$key.": ".(is_null($value)?'<span class="text-secondary">Нет данных</span>':$value);?></div><?
        }
    }

if(count($users->users)>0)
    {
    ?><div class="tree_container border-light"><?php
    foreach ($users->users as $k=>$v)
        {
        ?><div class="item_container border p-2 my-4"><?
            //var_dump(array_diff($v,$fields));
            $level=0;
            ?><div class="primary_fields_container w-100 fw-bolder d-flex flex-wrap pb-2 bg-light"><?
                foreach($fields as $key)
                    {
                    if(property_exists($v,$key))
                        {
                        get_value($key,$v->$key,'primary',$level);
                        }
                    }
            ?></div><?
            ?><div class="secondary_fields_container w-100 fw-normal d-flex flex-wrap pb-3 border-top"><?
            foreach ($v as $second_key=>$second_value)
                {
                if(!in_array($second_key,$fields))
                    {
                    get_value($second_key,$v->$second_key,'secondary',$level);
                    }
                }
            ?></div><?
        ?></div><?
        }
    ?></div><?php
    }


?><pre><?php var_dump($users->users);?></pre><?php


?>