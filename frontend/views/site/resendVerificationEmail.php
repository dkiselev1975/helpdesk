<?php

/** @var yii\web\View$this  */
/** @var yii\bootstrap5\ActiveForm $form */
/** @var ResetPasswordForm $model */

use frontend\models\ResetPasswordForm;
use yii\bootstrap5\Html;
use yii\bootstrap5\ActiveForm;

$this->title = Yii::$app->params['messages']['resend_verification_email']['page_title'];
?>
<div class="site-resend-verification-email">
    <p><?= Yii::$app->params['messages']['resend_verification_email']['sub_title'].'.' ?></p>

    <div class="row">
        <div class="col-lg-5">
            <?php $form = ActiveForm::begin(['id' => 'resend-verification-email-form']); ?>

            <?= $form->field($model, 'email')->textInput(['autofocus' => true])->label(Yii::$app->params['messages']['resend_verification_email']['fields']['email'].":") ?>

            <div class="form-group">
                <?= Html::submitButton(Yii::$app->params['messages']['resend_verification_email']['buttons']['send'], ['class' => 'btn btn-primary']) ?>
            </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
