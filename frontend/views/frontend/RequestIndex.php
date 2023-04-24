<?php
/** @var string $page_title */
/** @var string $empty_list_phrase */
use yii\base\BaseObject;
$this->title = $page_title;
$this->title=$page_title;
if(!empty($items)&&is_array($items))
{
    ?><table class="table table-bordered table-striped data-table">
    <tr>
        <th class="p-1 p-sm-2">Номер вагона</th>
        <th class="p-1 p-sm-2">Страна / Тариф (руб.)</th>
        <th class="d-none d-sm-table-cell p-1 p-sm-2">Статус запроса</th>
        <th class="d-none d-sm-table-cell p-1 p-sm-2">Выполнен</th>
    </tr>
    <?php
    foreach ($items as $item)
    {
        $formatter = Yii::$app->formatter;
        ?>
        <tr>
            <td class="p-1 p-sm-2 text-center"><?=$item['wagon_number'];?></td>
            <td class="p-1 p-sm-2 text-center"><?=($item['country_id']?$item->country->name:$formatter->asText(null))." / ".($item['price_of_request']?$formatter->asDecimal($item['price_of_request'],Yii::$app->params['currencyDecimalPlaces'])." р.":$formatter->asDecimal($item['price_of_request'],Yii::$app->params['currencyDecimalPlaces']));?></td>
            <td class="d-none d-sm-table-cell p-1 p-sm-2 text-center">
                <?php
                $cursor_type=$item->response_answer?'pointer':'default';
                $test_info=$item->debug_flag?' (Test)':'';
                if($item->repeated_flag)
                    {
                    ?><strong class="text-warning cursor-<?=$cursor_type;?>" title="<?=$item->response_answer;?>">Повторный<?=$test_info;?></strong><?php
                    }
                elseif(!$item->response_success)
                    {
                    ?><strong class="text-danger cursor-<?=$cursor_type;?>" title="<?=$item->response_answer;?>">Ошибка<?=$test_info;?></strong><?php
                    }
                else
                    {
                    ?><span class="text-success cursor-<?=$cursor_type;?>" title="<?=$item->response_answer;?>">Успешно<?=$test_info;?></span><?php
                    }
                ?>
            </td>
            <td class="d-none d-sm-table-cell p-1 p-sm-2 text-center"><?=$item->UpdatedAt;?></td>
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

