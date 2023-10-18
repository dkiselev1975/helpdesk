<?php

/** @var yii\web\View $this */
/** @var string $content */

use backend\assets\AppAsset;
use yii\helpers\Html;
use common\widgets\Alert;
Yii::$app->view->params['show_h1']=Yii::$app->view->params['show_h1']??true;
?>
<?php
if(Yii::$app->view->params['show_h1']){
    ?><h1 <?php if(isset($title_class)){?> class="<?=$title_class;?>"<?php }?>><?=Html::encode($this->title);?></h1><?php
}
?>
<?= Alert::widget() ?>
<?= $content ?>

