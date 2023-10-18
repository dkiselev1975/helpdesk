<?php

/* @var $this yii\web\View */
/* @var $name string */
/* @var $message string */
/* @var $buttons array */
/* @var $exception Exception */
/* @var $layout string */

use yii\helpers\Html;
$buttons_class='btn btn-lg btn-primary col-12 col-sm-auto m-2';

if(!preg_match('/^Ошибка/',$name)){$name='Ошибка: '.$name;}
$this->title = $name;
if(Yii::$app->request->isAjax)
    {
    $layout=Yii::$app->params['defaultGoodExceptionAjaxLayout'];
    }
else
    {
    $layout=$layout??Yii::$app->params['defaultGoodExceptionLayout'];
    }


?>

<?php $this->beginContent('@app/../backend/views/layouts/'.$layout.'.php',['title_class'=>'text-danger']); ?>
<?php
if(isset($message))
{
    ?>
    <div class="site-error">
        <div class="alert alert-danger">
            <?= nl2br($message);?>
        </div>
    </div>
    <?php
}
?><div class="row gx-3"><?php
if($buttons){
    foreach ($buttons as $item)
    {
        ?><a class="<?= $item['class']??$buttons_class ?>" href="<?= $item['href'];?>"><?= $item['title']; ?></a><?php
    }
}
else
{?><a class="<?= $buttons_class ?>" href="/">Начальная страница</a><?php }
?></div><?php
?>
<?php $this->endContent(); ?>