<?php

/** @var yii\web\View $this */
/** @var string $content */

use backend\assets\AppAsset;
use yii\helpers\Html;
use common\widgets\Alert;

Yii::$app->view->params['show_h1']=Yii::$app->view->params['show_h1']??true;
AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>" class="h-100">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <?php $this->registerCsrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body class="d-flex flex-column h-100">
<?php $this->beginBody() ?>

<main role="main" class="flex-grow-1 d-flex flex-column body-content">
    <div class="container container-sm flex-grow-1 d-flex flex-column justify-content-center pt-0">
        <?php
        if(Yii::$app->view->params['show_h1']){
            ?><h1 <?php if(isset($title_class)){?> class="<?=$title_class;?>"<?php }?>><?=Html::encode($this->title);?></h1><?php
            }
        ?>
        <?= Alert::widget() ?>
        <?= $content ?>
    </div>
</main>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage();
