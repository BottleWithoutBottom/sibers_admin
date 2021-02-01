<?
/** @var string $page */
/** @var string $title */
/** @var object $user */
use App\Mvc\Models\User;
use App\Core\Request;
$request = Request::getInstance();
?>

<div<?= $page ? ' class="' . $page . '-page' . '"' : '' ?>>
    <h1><?= $title ?></h1>

    <form action="/admin/list/create/" method="post">
        <label>
            <p>Login</p>
            <input type="text" value="<?= $request->getPost(User::LOGIN) ?>" name="<?= User::LOGIN ?>">
        </label>

        <label>
            <p>Password</p>
            <input type="password" name="<?= User::PASSWORD ?>">
        </label>

        <label>
            <p>Firstname</p>
            <input type="text" value="<?= $request->getPost(User::FIRSTNAME) ?>" name="<?= User::FIRSTNAME ?>">
        </label>

        <label>
            <p>Lastname</p>
            <input type="text" value="<?= $request->getPost(User::LASTNAME) ?>" name="<?= User::LASTNAME ?>">
        </label>

        <div>
            <button type="submit">Add user</button>
        </div>
    </form>
</div>
