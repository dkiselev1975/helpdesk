<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\User $user */
/** @var string $password */
/** @var bool $send_verification_link */

?>
<div class="verify-email">
    <p><?= Yii::$app->params['messages']['email']['hello'].' '.Html::encode($user->username).',' ?></p>
    <p><?= Yii::$app->params['messages']['email']['verify_link'].':' ?></p>
    <?php
    if($send_verification_link){
        $link = Yii::$app->urlManagerFrontend->createAbsoluteUrl(['site/verify-email', 'token' => $user->verification_token]);
    }
    else
        {
        $link = Yii::$app->urlManagerFrontend->createAbsoluteUrl(['site/login']);
        }
    ?>
    <p><?= Html::a(Html::encode($link), $link) ?></p>
    <p><?= "Логин: ".Html::encode($user->username);?></p>
    <p><?= "Пароль: ".$password;?></p>
</div>
