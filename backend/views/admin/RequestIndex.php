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
        <th>Номер вагона</th>
        <th>Логин пользователя</th>
        <th class="d-none d-sm-table-cell p-1 p-sm-2">E-mail</th>
        <th class="d-none d-sm-table-cell p-1 p-sm-2">Телефоны</th>
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
            <td class="p-1 p-sm-2 text-center"><?=$item->user->username;?></td>
            <td class="d-none d-sm-table-cell p-1 p-sm-2 text-nowrap"><a href="mailto:<?= $item->user->email;?>"><?=$item->user->email;?></a></td>
            <td class="d-none d-sm-table-cell p-1 p-sm-2 text-nowrap"><?= nl2br(implode("\n",[$item->user->phone_office,$item->user->phone_mobile]));?></td>
            <td class="d-none d-sm-table-cell p-1 p-sm-2 text-center"><?= $item->status?'Успешно':'<strong class="text-danger" title="'.$item->response.'">Ошибка</strong>';?></td>
            <td class="d-none d-sm-table-cell p-1 p-sm-2"><?=$item->updated;?></td>
        </tr>
        <?php
    }
    ?></table><?php
}
?>