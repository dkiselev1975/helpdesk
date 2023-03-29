<?php
/** @var string $page_title */
/** @var string $message */
/** @var string $error */
use yii\base\BaseObject;

$this->title = $page_title;
?><?= nl2br($message);?><?php
if(!empty($error)){
    ?>
    <hr class="mt-5">
    <?= nl2br($error);?><?php
    }
?>

