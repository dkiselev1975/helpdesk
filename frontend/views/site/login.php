<?php
use common\models\LoginForm;

/** @var yii\web\View $this */
/** @var yii\bootstrap5\ActiveForm $form */
/** @var LoginForm $model */

$this->title = Yii::$app->params['messages']['login']['page_title'];
$this->params['breadcrumbs'][] = $this->title;
LoginForm::LoginFormDraw($this->title,$model,true);