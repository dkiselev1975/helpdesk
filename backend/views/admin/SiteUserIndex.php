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
        <th>Логин</th>
        <th class="p-1 p-sm-2">E-mail</th>
        <th class="d-none d-lg-table-cell p-1 p-sm-2">Телефон</th>
        <th class="d-none d-lg-table-cell p-1 p-sm-2">Активен</th>
        <th class="d-none d-lg-table-cell p-1 p-sm-2">Обновлен</th>
        <th class="p-1 p-sm-2">Изменить</th>
        <th class="p-1 p-sm-2">Удалить</th>
    </tr>
    <?php
    foreach ($items as $item)
    {
        /*$item=SiteUser::DateTimeConvert($item,Yii::$app->params['date_formats']['php']['date_time_format']);*/
        ?>
        <tr<?php if(!(int)$item['active']){?> class="bg-warning"<?php };?>>
            <td class="p-1 p-sm-2"><?=$item['username'];?></td>
            <td class="p-1 p-sm-2"><?=$item['email'];?></td>
            <td class="d-none d-lg-table-cell p-1 p-sm-2 text-center"><?=$item['phone'];?></td>
            <td class="d-none d-lg-table-cell p-1 p-sm-2 text-center"><?=$item['active']?'Да':'Нет';?></td>
            <td class="d-none d-lg-table-cell p-1 p-sm-2 text-center"><?=$item['updated'];?></td>
            <td class="p-1 p-sm-2 text-center"><?= Html::a('<i class="fas fa-edit"></i>', '/site-user-edit-form/'.$item['id'], ['class'=>'btn btn-secondary']); ?></td>
            <td class="p-1 p-sm-2 text-center"><?= Html::a('<i class="fas fa-trash"></i>', '/site-user-delete/'.$item['id'], ['data-confirm'=>"Удалить запись?", 'class'=>'btn btn-danger']); ?></td>
        </tr>
        <?php
    }
    ?></table><?php
}
?>