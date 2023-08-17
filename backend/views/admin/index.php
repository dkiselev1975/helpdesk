<?php
/** @var yii\web\View $this */
/** @var array $items */
/** @var string $empty_list_phrase */
/** @var object $users */

$this->title = Yii::$app->params['app_name']['backend'];
?><p><strong>Count: </strong><?var_dump (count($users->users));?></p><?

$level=0;
$fields=array('name','jobtitle','phone','department');

function get_value(string $key,mixed $value,&$level)
    {
    $classes=array(
        0=>
            [
                'is_object'=>'main_object d-flex flex-wrap w-100',
                'is_scalar_value'=>'main_value fw-normal col-12 col-sm-4',
                'object_title'=>'object_title fw-bold w-100 border-bottom-1 bg-light'
            ],
        1=>
            [
                'is_object'=>'secondary_object d-flex flex-wrap w-100',
                'is_scalar_value'=>'secondary_value fw-normal d-none',
                'object_title'=>'object_title fw-bold w-100 border-bottom-1'
            ],
    );
    if(is_object($value))
        {
        $class=$classes[(int)((bool)$level)]['is_object'];
        ?><div class="<?=$class;?> ps-<?=$level?>"><?
        ?><div class="<?=$classes[(int)((bool)$level)]['object_title']?>"><?=$key." (is_obj)"." [".$level."]";?></div><?
        foreach ($value as $k=>$v)
            {
            $level++;
            get_value($k,$v,$level);
            --$level;
            }
        ?></div><?
        }
    else
        {
        $class=$classes[(int)((bool)$level)]['is_scalar_value'];
        ?><div class="<?=$class;?> ps-<?=$level?>"><?=$key.": ".$value." [".$level."]";?></div><?
        }
    }

if(count($users->users)>0)
    {
    ?><div class="tree_container"><?php
    foreach ($users->users as $k=>$v)
        {
        //var_dump(array_diff($v,$fields));
        $level=0;
        ?><div class="main_fields_container w-100 fw-bolder d-flex flex-wrap border-bottom pb-2 bg-light"><?
            foreach($fields as $key)
                {
                if(property_exists($v,$key)){get_value($key,$v->$key,$level);}
                }
        ?></div><?
        ?><div class="secondary_fields_container w-100 fw-normal d-flex flex-wrap border-bottom pb-3"><?
        foreach ($v as $second_key=>$second_value)
            {
            if(!in_array($second_key,$fields)){get_value($second_key,$v->$second_key,$level);}
            }
        ?></div><?
        }
    ?></div><?php
    }


?><pre><?php var_dump($users->users);?></pre><?php


?>