<?php

use common\models\User;
use common\models\Company;
use frontend\models\SignupForm;
use yii\base\BaseObject;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;
use yii\bootstrap5\Html;
use yii\helpers\Url;

/** @var yii\web\View $this */
/** @var SignupForm $model */
/** @var string $message */
/** @var string $page_title */
/** @var array $errors */
$this->title=$page_title;

if(isset($model))
{
    $status_items = [
        User::STATUS_ACTIVE => 'Активный',
        User::STATUS_INACTIVE => 'Не подтвержден',
        User::STATUS_DELETED=>'Удален'
    ];

    $form = ActiveForm::begin(['id' => 'SiteUserEditForm','options'=>['class' => 'col-lg-12']]); ?>
    <?= $form->field($model, 'username',['options'=>['class'=>'mb-2 fw-bold']])->textInput()->label(Yii::$app->params['messages']['signup']['fields']['username'].":",['class'=>'mb-1 fw-bold']); ?>
    <!---->
    <?= $form->field($model, 'person_name',['options'=>['class'=>'mb-2 fw-bold']])->textInput()->label(Yii::$app->params['messages']['signup']['fields']['person_name'].":",['class'=>'mb-1 fw-bold']); ?>
    <?= $form->field($model, 'person_patronymic',['options'=>['class'=>'mb-2 fw-bold']])->textInput()->label(Yii::$app->params['messages']['signup']['fields']['person_patronymic'].":",['class'=>'mb-1 fw-bold']); ?>
    <?= $form->field($model, 'person_surname',['options'=>['class'=>'mb-2 fw-bold']])->textInput()->label(Yii::$app->params['messages']['signup']['fields']['person_surname'].":",['class'=>'mb-1 fw-bold']); ?>
    <!---->
    <?= $form->field($model, 'email',['options'=>['class'=>'mb-2 fw-bold']])->textInput()->label(Yii::$app->params['messages']['signup']['fields']['email'].":",['class'=>'mb-1 fw-bold']); ?>
    <?php
    //Yii::Debug(get_class($model));
    if(get_class($model)==='frontend\\models\\SignupForm')
        {?>
        <?= $form->field($model, 'password')->passwordInput()->label(Yii::$app->params['messages']['signup']['fields']['password'].':') ?>
        <?php
        }
    ?>
    <?= $form->field($model, 'phone_office',['options'=>['class'=>'mb-2 fw-bold']])->textInput()->label(Yii::$app->params['messages']['signup']['fields']['phone_office'].':',['class'=>'mb-1 fw-bold']); ?>
    <?= $form->field($model, 'phone_mobile',['options'=>['class'=>'mb-2 fw-bold']])->textInput()->label(Yii::$app->params['messages']['signup']['fields']['phone_mobile'].':',['class'=>'mb-1 fw-bold']); ?>
    <?= $form->field($model, 'company_id',['options'=>['class'=>'mt-3 mb-2 fw-bold']])->dropDownList(arrayHelper::map(Company::find()->all(),'id','name'),['prompt'=>Yii::$app->params['messages']['signup']['fields']['company_id']['prompt'].'…'])->label(Yii::$app->params['messages']['signup']['fields']['company_id']['label'].':',['class'=>'mb-1']); ?>
    <?= $form->field($model, 'status',['options'=>['class'=>'mt-3 mb-2 fw-bold']])->dropDownList($status_items,['prompt' => Yii::$app->params['messages']['signup']['fields']['status']['prompt'].'…'])->label(Yii::$app->params['messages']['signup']['fields']['status']['label'].':',['class'=>'mb-1']); ?>
    <div class="form-group mt-4">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-primary']); ?>
    </div>
    <?= $form->field($model, 'note',['options'=>['class'=>'mt-3 mb-2 fw-bold']])->textarea(['rows' => 5, 'cols' => 80])->label('Примечание:',['class'=>'mb-1']); ?>
    <?php ActiveForm::end();
}
elseif(!empty($errors))
{
    $message='';
    foreach ($errors as $error)
    {
        $message.='<p>'.implode('</p><p>',$error).'</p>';
    }
    echo $message;
    ?><a class="btn btn-primary" href="<?php Url::previous('previous');?>">Вернуться</a><?php
}
?>