<?
/** @var string $title */
/** @var array $users */
/** @var string $page */
/** @var string $paginator */
?>

<div<?= $page ? ' class="' . $page . '-page' . '"' : '' ?>>
    <h1><?= $title ?></h1>

    <div class="users-list">
        <? if (!empty($users)): ?>
            <? foreach($users as $user):
                if ($user->status > 1) {
                    $statusStyle = 'confirmed';
                }
                ?>
                <div class="users-card" data-user-id="<?= $user->id?>">
                    <span><?= $user->login?></span>
                    <span><?= $user->firstname?></span>
                    <span><?= $user->lastname?></span>
                    <span><?= $user->birthday?></span>
                    <span class="users-card-status<?=$statusStyle ? '__confirmed' : ''?>"><?= $user->status?></span>
                    <a href="/admin/list/<?=$user->id?>/" class="users-card__show">Detail page</a>
                    <a href="/admin/list/<?=$user->id?>/edit/" class="users-card__edit">Edit</a>
                    <a href="/admin/list/<?=$user->id?>/delete/" class="users-card__delete">Delete</a>
                </div>
            <? endforeach; ?>
        <? else: ?>
            <i>The users list is empty</i>
            <a href="<?= SITE_DIR ?>">Back to the main page</a>
        <? endif; ?>
        <a class="users-list-add" href="/admin/list/add/">Add a new User</a>

        <?= $paginator ?>
    </div>
</div>