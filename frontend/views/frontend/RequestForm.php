<?php
/** @var string $page_title */
/** @var RequestForm $soap_request */

use common\models\RequestForm;
use yii\base\BaseObject;

$this->title = $page_title;
RequestForm::RequestFormDraw($soap_request);
?>