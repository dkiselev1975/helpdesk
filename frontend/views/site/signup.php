<?php

/** @var yii\web\View $this */
/** @var yii\bootstrap5\ActiveForm $form */
/** @var \frontend\models\SignupForm $model */

use yii\bootstrap5\Html;
use yii\bootstrap5\ActiveForm;

/*$this->title = 'Signup';*/
$this->title = Yii::$app->params['messages']['signup_form']['title'];

$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-signup">
    <h1><?= Html::encode($this->title) ?></h1>

    <!--<p>Please fill out the following fields to signup:</p>-->
    <p><?=Yii::$app->params['messages']['signup_form']['sub_title'];?>:</p>

    <div class="row">
        <div class="col-lg-5">
            <?php $form = ActiveForm::begin(['id' => 'form-signup']); ?>
                <?= $form->field($model, 'username')->textInput(['autofocus' => true])->label(Yii::$app->params['messages']['signup_form']['fields']['username'].":") ?>
                <?= $form->field($model, 'email')->label(Yii::$app->params['messages']['signup_form']['fields']['email'].":") ?>
                <?= $form->field($model, 'password')->passwordInput()->label(Yii::$app->params['messages']['signup_form']['fields']['password'].":") ?>
                <div class="form-group">
                    <?= Html::submitButton(Yii::$app->params['messages']['signup_form']['buttons']['signup'], ['class' => 'btn btn-primary', 'name' => 'signup-button']) ?>
                </div>
            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
