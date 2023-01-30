<?php
use common\models\LoginForm;

/** @var yii\web\View $this */
/** @var yii\bootstrap5\ActiveForm $form */
/** @var LoginForm $model */

/*use yii\bootstrap5\Html;
use yii\bootstrap5\ActiveForm;*/

$this->title = Yii::$app->params['messages']['login_form']['title'];
$this->params['breadcrumbs'][] = $this->title;
LoginForm::LoginFormDraw($this->title,$model,true);