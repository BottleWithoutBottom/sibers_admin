<?
/** @var string $page */
/** @var string $title */
/** @var object $user */
?>

<div<?= $page ? ' class="' . $page . '-page' . '"' : '' ?>>
    <h1><?=$title?></h1>

    <form action="/admin/list/<?= $user->id ?>/edit/" method="post">
        <label>
            <p>Логин</p>
            <input type="text" value="<?= $user->login ?>">
        </label>

        <label>
            <p>Имя</p>
            <input type="text" value="<?= $user->firstName ?>">
        </label>

        <label>
            <p>Фамилия</p>
            <input type="text" value="<?= $user->lastName ?>">
        </label>

        <input type="hidden" value="<? $user->id ?>">
        <div>
            <button type="submit">Подтвердить</button>
        </div>
    </form>
</div>
