<?php
/** @var yii\web\View $this */
/** @var array $news_list */
/** @var string $page_title */
/** @var string $empty_list_phrase */

$this->title=$page_title;
$formatter = Yii::$app->formatter;
if(!empty($items)&&is_array($items))
    {
    ?><table class="table table-bordered table-striped data-table">
    <tr>
        <th>Номер вагона</th>
        <th class="d-none d-lg-table-cell p-1 p-sm-2">Страна</th>
        <th>Логин пользователя</th>
        <th class="d-none d-lg-table-cell p-1 p-sm-2">E-mail запроса</th>
        <th class="d-none d-lg-table-cell p-1 p-sm-2">Телефоны</th>
        <th class="d-none d-sm-table-cell p-1 p-sm-2">Статус запроса</th>
        <th class="d-none d-lg-table-cell p-1 p-sm-2">Выполнен</th>
    </tr>
    <?php
    foreach ($items as $item)
    {
        //$tr_class=(!$item->status)?'text-danger':'';
        ?>
        <tr>
            <td class="p-1 p-sm-2 text-center"><?=$item['wagon_number'];?></td>
            <td class="d-none d-lg-table-cell p-1 p-sm-2 text-nowrap text-center"><?=$item['country_id']?$item->country->name:$formatter->asText($item['country_id']);?></td>
            <td class="p-1 p-sm-2 text-center"><a href="site-user-edit-form/<?=$item->user->id;?>" title="<?=implode(', ',[implode(' ',[$item->user->person_surname,$item->user->person_name,$item->user->person_patronymic]),$item->user->company->name]);?>"><?=$item->user->username;?></a></td>
            <td class="d-none d-lg-table-cell p-1 p-sm-2 text-nowrap"><a href="mailto:<?= $item['user_email'];?>"><?=$item['user_email'];?></a></td>
            <td class="d-none d-lg-table-cell p-1 p-sm-2 text-nowrap"><?= nl2br(implode("\n",[$item->user->phone_office,$item->user->phone_mobile]));?></td>
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
            <td class="d-none d-lg-table-cell p-1 p-sm-2 text-center"><?=$item->UpdatedAt;?></td>
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