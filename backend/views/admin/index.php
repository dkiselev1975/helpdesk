<?php
/** @var yii\web\View $this */
/** @var array $items */
/** @var string $empty_list_phrase */

$this->title = Yii::$app->params['app_name']['backend'];

$formatter = Yii::$app->formatter;
//Yii::debug($items);

if(!empty($items)&&is_array($items))
{
    ?><table class="table table-bordered table-striped data-table">
    <tr>
        <th class="p-1 p-sm-2">Пользователь</th>
        <th class="p-1 p-sm-2">Запросы</th>
        <th class="p-1 p-sm-2">Стоимость</th>
        <th class="p-1 p-sm-2 d-none d-sm-table-cell">День</th>
        <th class="p-1 p-sm-2 d-none d-sm-table-cell">Месяц</th>
        <th class="p-1 p-sm-2 d-none d-sm-table-cell">Год</th>
    </tr>
    <?php
    foreach ($items as $item)
    {
        if($item['user_id'])
            {
                $class_tr='fw-bold text-start bg-success';
                $class_td='text-start';
            }
        else{
            $class_tr='';
            $class_td='';
            }
        ?>

        <tr <?=$class_tr?'class="'.$class_tr.'"':'';?>>
            <td class="<?=$class_td?:'p-1 p-sm-2 text-center';?>"><?=$item['name']?$item['name']:$item['user_id'];?></td>
            <td class="p-1 p-sm-2 text-center"><?=$item['requests'];?></td>
            <td class="p-1 p-sm-2 text-center"><?=$formatter->asDecimal($item['price'],0).' '.Yii::$app->params['currencyShortName'];?></td>
            <td class="p-1 p-sm-2 text-center d-none d-sm-table-cell"><?=$item['day'];?></td>
            <td class="p-1 p-sm-2 text-center d-none d-sm-table-cell"><?=$item['month'];?></td>
            <td class="p-1 p-sm-2 text-center d-none d-sm-table-cell"><?=$item['year'];?></td>
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