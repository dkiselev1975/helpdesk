<?php
use common\models\LoginForm;

/** @var yii\web\View $this */
/** @var yii\bootstrap5\ActiveForm $form */
/** @var LoginForm $model */
/** @var boolean $show_h1 */

$this->title = Yii::$app->params['messages']['login']['page_title'];
Yii::$app->view->params['show_h1'] = false;
LoginForm::LoginFormDraw($this->title,$model,password_resend_reset: true,signup:true);