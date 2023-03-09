<?php

/** @var yii\web\View $this */
/** @var string $name */
/** @var string $message */
/** @var Exception $exception */

use yii\helpers\Html;

$this->title = $name;
?>
<div class="site-error">
    <div class="alert alert-danger">
        <?= nl2br(Html::encode($message)) ?>
    </div>

    <p><?= Yii::$app->params['messages']['errors']['error_pages']['server_error'][0]?></p>
    <p><?= Yii::$app->params['messages']['errors']['error_pages']['server_error'][1][0].'<a href="mailto:'.Yii::$app->params['adminEmail'].'">'.Yii::$app->params['messages']['errors']['error_pages']['server_error'][1][1].'</a>'.Yii::$app->params['messages']['errors']['error_pages']['server_error'][1][2].'.' ?></p>
</div>