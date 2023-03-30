<?php

/** @var yii\web\View $this */
/** @var yii\bootstrap5\ActiveForm $form */
/** @var SignupForm $model */

use common\models\Company;
use frontend\models\SignupForm;
use yii\bootstrap5\Html;
use yii\bootstrap5\ActiveForm;
use yii\helpers\ArrayHelper;

$this->title = Yii::$app->params['messages']['signup']['page_title'];
?>
<div class="site-signup">
    <p><?= Yii::$app->params['messages']['signup']['sub_title'].':' ?></p>

    <div class="row">
        <div class="col-lg-5">
            <?php $form = ActiveForm::begin(['id' => 'form-signup']); ?>
                <?= $form->field($model, 'username')->textInput(['autofocus' => true])->label(Yii::$app->params['messages']['signup']['fields']['username'].':') ?>
                <!---->
                <?= $form->field($model, 'person_name')->textInput()->label(Yii::$app->params['messages']['signup']['fields']['person_name'].':') ?>
                <?= $form->field($model, 'person_patronymic')->textInput()->label(Yii::$app->params['messages']['signup']['fields']['person_patronymic'].':') ?>
                <?= $form->field($model, 'person_surname')->textInput()->label(Yii::$app->params['messages']['signup']['fields']['person_surname'].':') ?>
                <!---->
                <?= $form->field($model, 'email')->label(Yii::$app->params['messages']['signup']['fields']['email'].":") ?>
                <?= $form->field($model, 'password')->passwordInput()->label(Yii::$app->params['messages']['signup']['fields']['password'].':') ?>
                <?= $form->field($model, 'phone_office')->textInput()->label(Yii::$app->params['messages']['signup']['fields']['phone_office'].':',['class'=>'mb-1']); ?>
                <?= $form->field($model, 'phone_mobile')->textInput()->label(Yii::$app->params['messages']['signup']['fields']['phone_mobile'].':',['class'=>'mb-1']); ?>
                <?= $form->field($model, 'company_id')->dropDownList(arrayHelper::map(Company::find()->where(['status'=>10])->all(),'id','name'),['prompt'=>Yii::$app->params['messages']['signup']['fields']['company_id']['prompt'].'…'])->label(Yii::$app->params['messages']['signup']['fields']['company_id']['label'].':',['class'=>'mb-1']); ?>
                <div class="form-group">
                    <?= Html::submitButton(Yii::$app->params['messages']['signup']['buttons']['signup'], ['class' => 'btn btn-primary', 'name' => 'signup-button']) ?>
                </div>
            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
