<?php

/** @var yii\web\View $this */
/** @var yii\bootstrap5\ActiveForm $form */
/** @var \common\models\LoginForm $model */

use yii\bootstrap5\Html;
use yii\bootstrap5\ActiveForm;

$this->title = Yii::$app->params['messages']['login_form']['title'];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-login">
    <h1><?= Html::encode($this->title) ?></h1>

    <p><?=Yii::$app->params['messages']['login_form']['sub_title'];?>:</p>

    <div class="row">
        <div class="col-lg-5">
            <?php $form = ActiveForm::begin(['id' => 'login-form']); ?>
                <?= $form->field($model, 'username')->textInput(['autofocus' => true])->label(Yii::$app->params['messages']['login_form']['fields']['username'].":") ?>
                <?= $form->field($model, 'password')->passwordInput()->label(Yii::$app->params['messages']['login_form']['fields']['password'].":") ?>
                <?= $form->field($model, 'rememberMe')->checkbox(['label'=>Yii::$app->params['messages']['login_form']['fields']['rememberMe']]) ?>
                <div class="my-1 mx-0" style="color:#999;">
                    <?= Yii::$app->params['messages']['login_form']['texts']['forgot_password'][0] ?> <?= Html::a(Yii::$app->params['messages']['login_form']['texts']['forgot_password'][1], ['site/request-password-reset']) ?>.
                    <br>
                    <?= Yii::$app->params['messages']['login_form']['texts']['resend'][0] ?> <?= Html::a(Yii::$app->params['messages']['login_form']['texts']['resend'][1], ['site/resend-verification-email']) ?>
                </div>

                <div class="form-group">
                    <?= Html::submitButton(Yii::$app->params['messages']['login_form']['buttons']['signup'], ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>
                </div>
            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
