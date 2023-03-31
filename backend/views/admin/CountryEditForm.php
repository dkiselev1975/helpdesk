<?php

use common\models\Country;
use yii\widgets\ActiveForm;
use yii\bootstrap5\Html;
use yii\helpers\Url;

/** @var yii\web\View $this */
/** @var Country $item */
/** @var string $message */
/** @var string $page_title */
/** @var array $errors */
$this->title=$page_title;

if(isset($item))
{
    $status_items = [
        Country::STATUS_ACTIVE => 'Активный',
        Country::STATUS_DELETED=>'Удален'
    ];

    $form = ActiveForm::begin(['id' => 'CountryEditForm','options'=>['class' => 'col-lg-12']]); ?>
    <?= $form->field($item, 'name',['options'=>['class'=>'mb-2 fw-bold']])->textInput()->label('Наименование:',['class'=>'mb-1 fw-bold']); ?>
    <?= $form->field($item, 'price_of_request',['options'=>['class'=>'mb-2 fw-bold col-12 col-sm-4']])->textInput()->label('Тариф:',['class'=>'mb-1 fw-bold']); ?>
    <?= $form->field($item, 'status',['options'=>['class'=>'mt-3 mb-2 fw-bold']])->dropDownList($status_items,['prompt' => 'Выберите статус…'])->label('Статус:',['class'=>'mb-1']); ?>
    <div class="form-group mt-4">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-primary']); ?>
    </div>
    <?= $form->field($item, 'note',['options'=>['class'=>'mt-3 mb-2 fw-bold']])->textarea(['rows' => 5, 'cols' => 80])->label('Примечание:',['class'=>'mb-1']); ?>
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