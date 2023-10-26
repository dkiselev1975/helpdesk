<?php

/** @var yii\web\View $this */
/** @var common\models\User $user */
/** @var string $password */
/** @var bool $send_verification_link */

?>
<?= Yii::$app->params['messages']['email']['hello'].','.' '.$user->username.',' ?>
<?= Yii::$app->params['messages']['email']['verify_link'].':'?>

<?php
if($send_verification_link){
    $link = Yii::$app->urlManagerFrontend->createAbsoluteUrl(['site/verify-email', 'token' => $user->verification_token]);
}
else
{
    $link = Yii::$app->urlManagerFrontend->createAbsoluteUrl(['site/login']);
}
?>
<?= $link;?>
<?= "Логин:".$user->username;?>
<?= "Пароль:".$password;?>