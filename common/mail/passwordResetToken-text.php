<?php

/** @var yii\web\View $this */
/** @var common\models\User $user */

$resetLink = Yii::$app->urlManager->createAbsoluteUrl(['site/reset-password', 'token' => $user->password_reset_token]);
?>
<?= Yii::$app->params['messages']['email']['hello'].' '.$user->username.',' ?>
<?= Yii::$app->params['messages']['email']['reset_password'] ?>
<?= $resetLink ?>
