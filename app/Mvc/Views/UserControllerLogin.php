<?
/* @var string $page */
/* @var string $title */
use App\Core\Request;
use App\Mvc\Models\User;
$request = Request::getInstance();
?>
<div<?= $page ? ' class="' . $page . '-page' . '"' : '' ?>>
    <h1><?= $title ?></h1>
    <form action="/user/authorize/" method="post">
        <label>
            <p>Логин</p>
            <input type="text" value="<?= $request->getPost(User::LOGIN) ?>" name="<?= User::LOGIN ?>">
        </label>

        <label>
            <p>Пароль</p>
            <input type="password" name="<?= User::PASSWORD ?>">
        </label>

        <div>
            <button type="submit">Войти</button>
        </div>
    </form>
</div>