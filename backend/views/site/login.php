<?php

use common\models\LoginForm;
/** @var yii\web\View $this */
/** @var yii\bootstrap5\ActiveForm $form */
/** @var LoginForm $model */

$this->title = Yii::$app->params['messages']['login']['page_title'];
Yii::$app->view->params['show_h1'] = false;
LoginForm::LoginFormDraw($this->title,$model);
?>
