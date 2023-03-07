<?php
/** @var string $page_title */
/** @var string $message */

use yii\base\BaseObject;

$this->title = $page_title;
?><p><?= nl2br($message);?></p><?php
?>