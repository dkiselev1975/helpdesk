<?php
/** @var string $page_title */
/** @var DislocationRequestFrom $soap_request */

use frontend\models\DislocationRequestFrom;
use yii\base\BaseObject;

$this->title = $page_title;
DislocationRequestFrom::RequestFormDraw($soap_request);
?>