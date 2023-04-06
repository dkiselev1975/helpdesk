<?php
use common\models\Company;
use common\models\Country;
use yii\bootstrap5\Html;

/** @var yii\web\View $this */
/** @var array $news_list */
/** @var string $page_title */
/** @var string $empty_list_phrase; */

$this->title=$page_title;
$formatter = Yii::$app->formatter;
if(!empty($items)&&is_array($items))
    {
    ?><table class="table table-bordered table-striped data-table">
    <tr>
        <th class="p-1 p-sm-2 w-50">Наименование</th>
        <th class="p-1 p-sm-2">Тариф (руб.)</th>
        <th class="p-1 p-sm-2">Изменить</th>
        <th class="p-1 p-sm-2 d-none d-sm-table-cell">Удалить</th>
    </tr>
    <?php
    foreach ($items as $item)
    {
        $tr_class = match ($item['status']) {
            Country::STATUS_DELETED => "deleted",
            default => '',
        };
        ?>
        <tr<?php if($tr_class){?> class="<?= $tr_class;?>"<?php }?>>
            <td class="p-1 p-sm-2"><?=$item['name'];?></td>
            <td class="p-1 p-sm-2 text-center"><?=$item['price_of_request']?$formatter->asDecimal($item['price_of_request'],Yii::$app->params['currencyDecimalPlaces'])." р.":$formatter->asDecimal($item['price_of_request'],Yii::$app->params['currencyDecimalPlaces']);?></td>
            <td class="p-1 p-sm-2 text-center"><?= Html::a('<i class="fas fa-edit"></i>', '/country-edit-form/'.$item['id'], ['class'=>'btn btn-secondary']); ?></td>
            <td class="p-1 p-sm-2 text-center d-none d-sm-table-cell"><?= Html::a('<i class="fas fa-trash"></i>', '/country-delete/'.$item['id'], ['data-confirm'=>"Удалить запись?", 'class'=>'btn btn-danger']); ?></td>
        </tr>
        <?php
    }
    ?></table><?php
    }
else
    {
    ?><strong><?=$empty_list_phrase;?></strong><?php
    }
?>