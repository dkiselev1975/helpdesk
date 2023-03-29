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
        <th class="d-none d-sm-table-cell p-1 p-sm-2">E-mail запроса</th>
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
            <td class="p-1 p-sm-2 text-center"><a href="site-user-edit-form/<?=$item->user->id;?>" title="<?=implode(', ',[implode(' ',[$item->user->person_surname,$item->user->person_name,$item->user->person_patronymic]),$item->user->company->name]);?>"><?=$item->user->username;?></a></td>
            <td class="d-none d-sm-table-cell p-1 p-sm-2 text-nowrap"><a href="mailto:<?= $item['user_email'];?>"><?=$item['user_email'];?></a></td>
            <td class="d-none d-sm-table-cell p-1 p-sm-2 text-nowrap"><?= nl2br(implode("\n",[$item->user->phone_office,$item->user->phone_mobile]));?></td>
            <td class="d-none d-sm-table-cell p-1 p-sm-2 text-center"><?= ($item->response_success&&!$item->repeated_flag)?'Успешно':'<strong class="text-danger" title="'.$item->response_answer.'">Ошибка</strong>';?></td>
            <td class="d-none d-sm-table-cell p-1 p-sm-2"><?=$item->UpdatedAt;?></td>
        </tr>
        <?php
    }
    ?></table><?php
}
?>