<?php

/** @var \yii\web\View $this */
/** @var string $content */
/** @var string $title_class */

use backend\assets\AppAsset;
use common\widgets\Alert;
use yii\bootstrap5\Breadcrumbs;
use yii\bootstrap5\Html;
use yii\helpers\Url;

AppAsset::register($this);

?>
<?php $this->beginPage() ?>
    <!DOCTYPE html>
    <html lang="<?= Yii::$app->language ?>" class="h-100">
    <head>
        <title><?= $this->title?Html::encode(implode(" | ",array(Yii::$app->params['app_name'],$this->title))):Html::encode(Yii::$app->params['app_name'])?></title>
        <?= Html::csrfMetaTags() ?>
        <meta charset="<?= Yii::$app->charset ?>">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <?php $this->registerCsrfMetaTags() ?>
        <?php $this->head() ?>
    </head>
    <body class="d-flex flex-column h-100">
    <?php $this->beginBody() ?>
    <header>
        <nav id="w0" class="navbar navbar-expand-md navbar-dark bg-dark fixed-top">
            <div class="container flex-nowrap px-2 px-sm-4">
                <a class="navbar-brand" href="/">
                    <div class="d-none d-sm-block"><?=\Yii::$app->params['app_name'];?></div>
                    <div class="d-block d-sm-none"><?=\Yii::$app->params['app_name_short'];?></div>
                </a>
                <?php
                if (Yii::$app->user->isGuest) {
                    echo Html::tag('div',Html::a(Yii::$app->params['messages']['navbar']['Login'],Url::To(['site/login']),['class' => ['btn btn-link login text-decoration-none text-nowrap']]),['class' => ['d-flex']]);
                } else {
                    echo Html::beginForm(Url::To(['admin/logout']), 'post', ['class' => 'd-flex'])
                        . Html::submitButton(
                            Yii::$app->params['messages']['navbar']['Logout'].' (' . Yii::$app->user->identity->username . ')',
                            ['class' => 'btn btn-link logout text-decoration-none text-nowrap']
                        )
                        . Html::endForm();
                }
                ?>
        </nav>
    </header>
    <main role="main" class="flex-grow-1">
        <div class="container-xxl d-flex px-0 h-100">
            <div class="justify-content-between col-12 row px-2 px-sm-4 m-0 flex-column flex-lg-row">
                <div class="col-12 col-lg-2 text-center text-sm-start bg-light p-3">
                    <nav class="list-unstyled">
                        <?php
                        foreach (\Yii::$app->params['left_menu'] as $item)
                        {
                            ?><li class="<?=$item['class']??''?>"><a href="/<?= $item['url']?>"><?= $item['label']?></a></li>
                            <?php
                        }
                        ?>
                        <li class="fw-bold mb-2"><?=  yii\helpers\BaseHtml::a('Схема рабочих мест',Url::to('@web/docs/work_places_numbers.pdf'),['target'=>'_blank']);?></li>
                    </nav>
                </div>
                <main class="col-12 col-lg-10 body-content pt-4 px-0 px-sm-3 m-0 flex-grow-1">
                    <?php
                    if(isset($title_class))
                            {
                            $title_class=implode(' ',["text-center","text-sm-start",$title_class]);
                            }
                    else
                        {
                            $title_class=implode(' ',["text-center","text-sm-start"]);
                        }
                    ?>
                    <h1 class="<?=$title_class;?>"><?=Html::encode($this->title);?></h1>
                    <?= Breadcrumbs::widget(['links' => $this->params['breadcrumbs'] ?? []])?>
                    <?= Alert::widget() ?>
                    <?= $content ?>
                </main>
            </div>
        </div>
    </main>
    <footer>
        <div class="row m-0"><div class="col-12 text-center bg-info p-2 bg-secondary text-white">&copy <?= \Yii::$app->params['company_name'].', '.date('Y').' г.'?></div></div>
    </footer>
    <?php $this->endBody() ?>
    </body>
    </html>
<?php $this->endPage();
