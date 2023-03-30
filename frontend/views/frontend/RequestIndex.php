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
        <th>Номер вагона</th>
        <th class="d-none d-sm-table-cell p-1 p-sm-2">Статус запроса</th>
        <th class="d-none d-sm-table-cell p-1 p-sm-2">Выполнен</th>
    </tr>
    <?php
    foreach ($items as $item)
    {
        //$tr_class=(!$item->status)?'text-danger':'';
        ?>
        <tr>
            <td class="p-1 p-sm-2 text-center"><?=$item['wagon_number'];?></td>
            <td class="d-none d-sm-table-cell p-1 p-sm-2 text-center">
                <?php if($item->repeated_flag)
                {
                    ?><strong class="text-warning cursor-pointer" title="<?=$item->response_answer;?>">Повторный</strong><?php
                }
                elseif(!$item->response_success)
                {
                    ?><strong class="text-danger cursor-pointer" title="<?=$item->response_answer;?>">Ошибка</strong><?php
                }
                else
                {
                    ?><span class="text-success cursor-default">Успешно</span><?php
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

