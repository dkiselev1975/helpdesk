<?php

/** @var yii\web\View $this */
/** @var common\models\User $user */

$verifyLink = Yii::$app->urlManager->createAbsoluteUrl(['site/verify-email', 'token' => $user->verification_token]);
?>
<?= Yii::$app->params['messages']['email']['hello'].','.' '.$user->username.',' ?>
<?= Yii::$app->params['messages']['email']['verify_link'].':'?>
<?= $verifyLink ?>