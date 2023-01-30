<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\User $user */

$resetLink = Yii::$app->urlManager->createAbsoluteUrl(['site/reset-password', 'token' => $user->password_reset_token]);
?>
<div class="password-reset">
    <p><?= Yii::$app->params['messages']['email']['hello'].' '.Html::encode($user->username).',' ?></p>
    <p><?= Yii::$app->params['messages']['email']['reset_password'].':' ?></p>
    <p><?= Html::a(Html::encode($resetLink), $resetLink) ?></p>
</div>