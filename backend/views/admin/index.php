<?php
/** @var yii\web\View $this */
/** @var array $items */
/** @var string $empty_list_phrase */
/** @var object $users */

$this->title = Yii::$app->params['app_name']['backend'];
var_dump (count($users->users));

$level=0;
$fields=array('name','jobtitle','login_name','first_name','middle_name','last_name','department');

function get_value(string $key,mixed $value,&$level)
    {
    $level++;
    if($level<=1){$tag="td";}else{$tag="ul";}
    echo "<".$tag.">";
    if(!is_object($value))
        {
        if($tag==='td')
            {
            echo $key.": ".$value." [".$level."]";
            }
        else
            {
            ?><li><?=$key.": ".$value." [".$level."]";?></li><?
            }
        }
    else
        {
        if($tag==='td')
            {
            echo $key." (is_obj)"." [".$level."]";
            }
        else
            {
            ?><li><?=$key." (is_obj)"." [".$level."]";?></li><?
            }
        foreach ($value as $k=>$v)
            {
            get_value($k,$v,$level);
            }
        }
    echo "</".$tag.">";
    --$level;
    }

if(count($users->users)>0)
    {
    ?><table class="table table-bordered table-striped data-table"><?php
    foreach ($users->users as $k=>$v)
        {
        $level=0;
        ?><tr><?
            foreach($fields as $key)
                {
                get_value($key,$v->$key,$level);
                }
        ?></tr><?
        }
    ?></table><?php
    }


?><pre><?php var_dump($users->users);?></pre><?php


?>