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

$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-signup">
    <h1><?= Html::encode($this->title) ?></h1>

    <p><?= Yii::$app->params['messages']['signup']['sub_title'].':' ?></p>

    <div class="row">
        <div class="col-lg-5">
            <?php $form = ActiveForm::begin(['id' => 'form-signup']); ?>
                <?= $form->field($model, 'username')->textInput(['autofocus' => true])->label(Yii::$app->params['messages']['signup']['fields']['username'].':') ?>
                <?= $form->field($model, 'email')->label(Yii::$app->params['messages']['signup']['fields']['email'].":") ?>
                <?= $form->field($model, 'password')->passwordInput()->label(Yii::$app->params['messages']['signup']['fields']['password'].':') ?>
                <?= $form->field($model, 'phone_office')->textInput()->label(Yii::$app->params['messages']['signup']['fields']['phone_office'].':',['class'=>'mb-1 fw-bold']); ?>
                <?= $form->field($model, 'phone_mobile')->textInput()->label(Yii::$app->params['messages']['signup']['fields']['phone_mobile'].':',['class'=>'mb-1 fw-bold']); ?>
                <?= $form->field($model, 'company_id')->dropDownList(arrayHelper::map(Company::find()->all(),'id','name'),['prompt'=>'Выберите компанию…'])->label('Компания:',['class'=>'mb-1']); ?>
                <div class="form-group">
                    <?= Html::submitButton(Yii::$app->params['messages']['signup']['buttons']['signup'], ['class' => 'btn btn-primary', 'name' => 'signup-button']) ?>
                </div>
            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
