<?php
/** @var yii\web\View $this */
/** @var array $items */
/** @var string $empty_list_phrase */
/** @var object $users */

$this->title = Yii::$app->params['app_name']['backend'];
foreach ($users->users as $v)
    {
    echo $v->last_name."|".$v->jobtitle."<br>";
    }
?><pre><?php var_dump($users);?></pre><?php
?>