<?php
/** @var yii\web\View $this */
/** @var array $items */
/** @var string $empty_list_phrase */
/** @var object $users */

$this->title = Yii::$app->params['app_name']['backend'];
?><p><strong>Count: </strong><?var_dump (count($users->users));?></p><?

$level=0;
$fields=array('name','jobtitle','phone','department');

function get_value(string $key,mixed $value,&$level,string $class='d-flex flex-column')
    {
    $level++;
    if(!is_object($value))
        {
        ?><div class="fw-normal"><?=$key.": ".$value." [".$level."]";?></div><?
        }
    else
        {
        ?><div class="<?=$class;?>"><?
        echo $key." (is_obj)"." [".$level."]";
        foreach ($value as $k=>$v)
            {
            get_value($k,$v,$level,'fw-bold d-flex py-1 flex-column');
            }
        ?></div><?
        }
    --$level;
    }

if(count($users->users)>0)
    {
    ?><div class="d-flex flex-column"><?php
    foreach ($users->users as $k=>$v)
        {
        //var_dump(array_diff($v,$fields));
        $level=0;
        ?><div class="d-flex flex-wrap flex-grow-1 fw-bolder border-bottom pb-2 bg-light"><?
            foreach($fields as $key)
                {
                if(property_exists($v,$key)){get_value($key,$v->$key,$level,"w-100 1 fw-bold d-flex flex-column pr-3");}
                }
        ?></div><?
        ?><div class="flex-grow-1 fw-normal d-flex flex-column border-bottom pb-3"><?
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