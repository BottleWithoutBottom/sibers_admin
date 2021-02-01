<?
/** @var string $page */
/** @var string $title */
/** @var object $user */
use App\Mvc\Models\User;
?>

<div<?= $page ? ' class="' . $page . '-page' . '"' : '' ?>>
    <h1><?=$title?></h1>

    <form action="/admin/list/<?= $user->id ?>/update/" method="post">
        <label>
            <p>Login</p>
            <input type="text" value="<?= $user->login ?>" name="<?= User::LOGIN ?>">
        </label>

        <label>
            <p>Firstname</p>
            <input type="text" value="<?= $user->firstname ?>" name="<?= User::FIRSTNAME ?>">
        </label>

        <label>
            <p>Lastname</p>
            <input type="text" value="<?= $user->firstname ?>" name="<?= User::LASTNAME ?>">
        </label>

        <input type="hidden" value="<?= $user->id ?>" name="<?= User::ID ?>">
        <div>
            <button type="submit">Confirm</button>
        </div>
    </form>
</div>
