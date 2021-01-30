<?
/** @var string $title */
/** @var array $users */
/** @var string $page */
?>

<div<?= $page ? ' class="' . $page . '-page' . '"' : '' ?>>
    <h1><?= $title ?></h1>

    <div class="users-list">
        <? if (!empty($users)): ?>
            <? foreach($users as $user):
                if ($user->status > 0) {
                    $statusStyle = 'confirmed';
                }
                ?>
                <div class="users-card" data-user-id="<?= $user->id?>">
                    <span><?= $user->login?></span>
                    <span><?= $user->firstname?></span>
                    <span><?= $user->lastname?></span>
                    <span><?= $user->birthday?></span>
                    <span class="users-card-status<?=$statusStyle ? '__confirmed' : ''?>"><?= $user->status?></span>
                    <a href="/admin/list/<?=$user->id?>/" class="users-card__show">На детальную</a>
                    <a href="/admin/list/<?=$user->id?>/edit/" class="users-card__edit">Редактировать</a>
                    <a href="/admin/list/<?=$user->id?>/delete/" class="users-card__delete">Удалить</a>
                </div>
            <? endforeach; ?>
        <? else: ?>
            <i>Список пользователей пуст</i>
            <a href="<?= SITE_DIR ?>">Вернуться на главную</a>
        <? endif; ?>
    </div>
</div>