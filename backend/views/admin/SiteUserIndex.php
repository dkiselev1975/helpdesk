<?php
use common\models\SiteUser;
use yii\bootstrap5\Html;

/** @var yii\web\View $this */
/** @var array $news_list */
/** @var string $page_title */

$this->title=$page_title;
?>
<?php
if(!empty($items)&&is_array($items))
{
    ?><table class="table table-bordered table-striped subscriber-list data-table">
    <tr>
        <th>E-mail</th>
        <th class="d-none d-lg-table-cell p-1 p-sm-2">Активен</th>
        <th class="d-none d-lg-table-cell p-1 p-sm-2">Обновлен</th>
        <th class="p-1 p-sm-2">Изменить</th>
        <th class="p-1 p-sm-2">Удалить</th>
    </tr>
    <?php
    foreach ($items as $item)
    {
        $item=SiteUser::DateTimeConvert($item,Yii::$app->params['date_formats']['php']['date_time_format']);
        ?>
        <tr<?php if(!(int)$item['active']){?> class="bg-warning"<?php };?>>
            <td class="w-50 p-1 p-sm-2"><?=$item['email'];?></td>
            <td class="text-center d-none d-lg-table-cell p-1 p-sm-2"><?=$item['active']?'Да':'Нет';?></td>
            <td class="text-center d-none d-lg-table-cell p-1 p-sm-2"><?=$item['updated'];?></td>
            <td class="text-center p-1 p-sm-2"><?= Html::a('<i class="fas fa-edit"></i>', '/subscriber-edit-form/'.$item['id'], ['class'=>'btn btn-secondary']); ?></td>
            <td class="text-center p-1 p-sm-2"><?= Html::a('<i class="fas fa-trash"></i>', '/subscriber-delete/'.$item['id'], ['data-confirm'=>"Удалить запись?", 'class'=>'btn btn-danger']); ?></td>
        </tr>
        <?php
    }
    ?></table><?php
}
?>