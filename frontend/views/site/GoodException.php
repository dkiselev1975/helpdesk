<?php

/* @var $this yii\web\View */
/* @var $name string */
/* @var $message string */
/* @var $exception Exception */

use yii\helpers\Html;

$this->title = "Ошибка: ".$name;
?>

<?php $this->beginContent('@app/views/layouts/main.php',['title_class'=>'text-danger']); ?>
    <?php
    if(isset($message))
        {?>
        <h1 class="alert-primary"><?= $name; ?></h1>
            <div class="site-error">
                <?= nl2br(Html::encode($message));?>
        </div>
        <?php
        }
    ?>
    <a class="btn btn-lg my-2 btn-primary col-12 col-sm-4 col-xl-3" href="/">Начальная страница</a>
<?php $this->endContent(); ?>