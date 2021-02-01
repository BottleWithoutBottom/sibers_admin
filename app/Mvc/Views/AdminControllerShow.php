<?
/** @var string $page */
/** @var string $title */
/** @var object $user */
?>

<div<?= $page ? ' class="' . $page . '-page' . '"' : '' ?>>
    <h1><?=$title?></h1>

    <form action="/admin/list/<?= $user->id ?>/edit/" method="post">
        <label>
            <p>Login</p>
            <input type="text" value="<?= $user->login ?>">
        </label>

        <label>
            <p>Firstname</p>
            <input type="text" value="<?= $user->firstname ?>">
        </label>

        <label>
            <p>Lastname</p>
            <input type="text" value="<?= $user->firstname ?>">
        </label>

        <input type="hidden" value="<? $user->id ?>">
        <div>
            <button type="submit">Confrim</button>
        </div>
    </form>
</div>
