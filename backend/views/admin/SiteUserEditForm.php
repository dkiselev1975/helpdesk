<?php

use common\models\SiteUser;
use yii\widgets\ActiveForm;
use yii\bootstrap5\Html;
use yii\helpers\Url;

/** @var yii\web\View $this */
/** @var SiteUser $item */
/** @var string $message */
/** @var string $page_title */
/** @var array $errors */
$this->title=$page_title;

if(isset($item))
{
    $form = ActiveForm::begin(['id' => 'SiteUserEditForm','options'=>['class' => 'col-lg-12']]); ?>
    <?= $form->field($item, 'username',['options'=>['class'=>'mb-2 fw-bold']])->textInput()->label('Логин',['class'=>'mb-1 fw-bold']); ?>
    <?= $form->field($item, 'email',['options'=>['class'=>'mb-2 fw-bold']])->textInput()->label('E-mail',['class'=>'mb-1 fw-bold']); ?>
    <?= $form->field($item, 'phone',['options'=>['class'=>'mb-2 fw-bold']])->textInput()->label('Телефон',['class'=>'mb-1 fw-bold']); ?>
    <?= $form->field($item, 'active',['options'=>['class'=>'mt-3 mb-2 fw-bold']])->checkbox(['label'=>'Активен','class'=>'mb-1']); ?>
    <div class="form-group mt-4">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-primary']); ?>
    </div>
    <?= $form->field($item, 'note',['options'=>['class'=>'mt-3 mb-2 fw-bold']])->textarea(['rows' => 5, 'cols' => 80])->label('Примечание',['class'=>'mb-1']); ?>
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