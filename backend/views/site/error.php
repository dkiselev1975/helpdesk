<?php

/** @var yii\web\View $this */
/** @var string $name */
/** @var string $message */
/** @var Exception $exception */

use yii\helpers\Html;

$this->title = $name;
Yii::$app->view->params['show_h1'] = false;
?>
<div class="site-error col-12 col-sm-8 mx-auto">
    <h1><?= Html::encode($this->title);?></h1>
    <div class="alert alert-danger">
        <?= nl2br(Html::encode($message)) ?>
    </div>
    <p><?= Yii::$app->params['messages']['errors']['error_pages']['server_error'][0]?></p>
    <p><?= Yii::$app->params['messages']['errors']['error_pages']['server_error'][1][0].'<a href="mailto:'.Yii::$app->params['adminEmail'].'">'.Yii::$app->params['messages']['errors']['error_pages']['server_error'][1][1].'</a>'.Yii::$app->params['messages']['errors']['error_pages']['server_error'][1][2].'.'?></p>
    <hr class="my-4">
    <p><a class="btn btn-primary px-4" href="<?=Yii::$app->homeUrl;?>"><?= Yii::$app->params['messages']['errors']['error_pages']['server_error'][2]?></a></p>

</div>