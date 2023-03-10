<?php
use common\models\SiteUser;
use common\models\User;
use yii\bootstrap5\Html;

/** @var yii\web\View $this */
/** @var array $news_list */
/** @var string $page_title */

$this->title=$page_title;
?>
<?php
if(!empty($items)&&is_array($items))
{
    ?><table class="table table-bordered table-striped data-table">
    <tr>
        <th>Логин, Ф.И.О</th>
        <th class="d-none d-sm-table-cell p-1 p-sm-2">E-mail</th>
        <th class="d-none d-xl-table-cell p-1 p-sm-2">Телефоны</th>
        <th class="d-none d-lg-table-cell p-1 p-sm-2">Компания</th>
        <th class="d-none d-lg-table-cell p-1 p-sm-2">Активен</th>
        <th class="d-none d-xl-table-cell p-1 p-sm-2">Создан / Обновлен</th>
        <th class="p-1 p-sm-2">Изменить</th>
        <th class="p-1 p-sm-2">Удалить</th>
    </tr>
    <?php
    foreach ($items as $item)
    {
        $tr_class = match ($item['status']) {
            User::STATUS_INACTIVE => "inactive",
            User::STATUS_DELETED => "deleted",
            default => '',
        };
        $item=SiteUser::DateTimeConvert($item,Yii::$app->params['date_formats']['php']['date_time_format']);
        ?>
        <tr<?php if($tr_class){?> class="<?= $tr_class;?>"<?php }?>>
            <td class="p-1 p-sm-2"><?=nl2br(implode("\n",["<strong>".$item['username']."</strong>",implode(' ',[$item['person_name'],$item['person_patronymic'],$item['person_surname']])]));?></td>
            <td class="d-none d-sm-table-cell p-1 p-sm-2"><?='<a href="mailto:'.$item['email'].'">'.$item['email'].'</a>';?></td>
            <td class="d-none d-xl-table-cell p-1 p-sm-2 text-nowrap"><?=implode('<br>',[$item['phone_office'],$item['phone_mobile']]);?></td>
            <td class="d-none d-lg-table-cell p-1 p-sm-2 text-center"><?=$item->company->name??'<span class="text-danger fw-bold">Не указана<span>';?></td>
            <td class="d-none d-lg-table-cell p-1 p-sm-2 text-center"><?=$item['status']==User::STATUS_ACTIVE?'Да':'Нет';?></td>
            <td class="d-none d-xl-table-cell p-1 p-sm-2 text-center"><?=implode('<br>',[$item['created_at'],$item['updated_at']]);?></td>
            <td class="p-1 p-sm-2 text-center"><?= Html::a('<i class="fas fa-edit"></i>', '/site-user-edit-form/'.$item['id'], ['class'=>'btn btn-secondary']); ?></td>
            <td class="p-1 p-sm-2 text-center"><?= Html::a('<i class="fas fa-trash"></i>', '/site-user-delete/'.$item['id'], ['data-confirm'=>"Удалить запись?", 'class'=>'btn btn-danger']); ?></td>
        </tr>
        <?php
    }
    ?></table><?php
}
?>