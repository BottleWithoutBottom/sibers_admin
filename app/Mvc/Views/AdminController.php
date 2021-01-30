<?
/** @var string $title */
/** @var array $users */
/** @var string $page */
?>

<div<?= $page ? ' class="' . $page . '-page' . '"' : '' ?>>
    <div class="menu">
        <a href="/">На главную</a>
        <a href="/admin/">Админ</a>
    </div>
    <h1><?= $title ?></h1>

    <div class="users-list">
        <? if (!empty($users)): ?>
            <? foreach($users as $user):
                if ($user->status > 0) {
                    $statusStyle = 'confirmed';
                }
                ?>
                <div class="users-card">
                    <span><?= $user->login?></span>
                    <span><?= $user->firstname?></span>
                    <span><?= $user->lastname?></span>
                    <span><?= $user->birthday?></span>
                    <span class="users-card-status<?=$statusStyle ? '__confirmed' : ''?>"><?= $user->status?></span>
                    <a class="users-card__edit">Редактировать</a>
                    <a href="/admin/list/<?=$user->id?>/delete" class="users-card__delete">Удалить</a>
                </div>
            <? endforeach; ?>
        <? else: ?>
            <i>Список пользователей пуст</i>
            <a href="<?= SITE_DIR ?>">Вернуться на главную</a>
        <? endif; ?>
    </div>
</div>