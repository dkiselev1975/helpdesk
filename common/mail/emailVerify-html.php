<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\User $user */

$verifyLink = Yii::$app->urlManager->createAbsoluteUrl(['site/verify-email', 'token' => $user->verification_token]);
?>
<div class="verify-email">
    <p><?= Yii::$app->params['messages']['email']['hello'].' '.Html::encode($user->username).',' ?></p>
    <p><?= Yii::$app->params['messages']['email']['verify_link'].':' ?></p>
    <p><?= Html::a(Html::encode($verifyLink), $verifyLink) ?></p>
</div>
