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
        <div class="site-error">
            <div class="alert alert-danger fw-bold">
                <?= nl2br(Html::encode($message));?>
            </div>
        </div>
        <?php
        }
    ?>
    <a class="btn btn-lg my-2 btn-primary col-12 col-sm-4 col-xl-3" href="/">Начальная страница</a>
<?php $this->endContent(); ?>