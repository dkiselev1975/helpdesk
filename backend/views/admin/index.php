<?php
/** @var yii\web\View $this */
/** @var array $items */
/** @var string $empty_list_phrase */
/** @var object $users */

$this->title = Yii::$app->params['app_name']['backend'];
var_dump (count($users->users));

$level=0;
function get_value(string $key,mixed $value,&$level)
    {
    $level++;
    if($level==1){?><td><?}
    ?><ul><?
    if(!is_object($value))
        {
        ?><li><?=$key.": ".$value."[".$level."]";?></li><?
        }
    else
        {
        ?><li><?=$key."(is_obj)"."[".$level."]";?></li><?
        foreach ($value as $k=>$v)
            {
            get_value($k,$v,$level);
            }
        }
    ?></ul><?
    if($level==1){?></td><?}
    --$level;
    }

if(count($users->users)>0)
    {
    ?><table class="table table-bordered table-striped data-table"><?php
    foreach ($users->users as $k=>$v)
        {
        $level=0;
        ?><tr><?php
        get_value($k,$v,$level);
        ?></tr><?php
        }
    ?></table><?php
    }


?><pre><?php var_dump($users->users);?></pre><?php


?>