<?
/* @var string $page */
/* @var string $title */
use App\Core\Request;
use App\Mvc\Models\User;
$request = Request::getInstance();
?>
<div<?= $page ? ' class="' . $page . '-page' . '"' : '' ?>>
    <h1><?= $title ?></h1>
    <form action="/user/reg/" method="post">
        <label>
            <p>Логин</p>
            <input type="text" value="<?= $request->getPost(User::LOGIN) ?>" name="<?= User::LOGIN ?>">
        </label>

        <label>
            <p>Пароль</p>
            <input type="password" name="<?= User::PASSWORD ?>">
        </label>

        <label>
            <p>Имя</p>
            <input type="text" name="<?= User::FIRSTNAME ?>" value="<?= $request->getPost(User::FIRSTNAME) ?>">
        </label>

        <label>
            <p>Фамилия</p>
            <input type="text" name="<?= User::LASTNAME ?>" value="<?= $request->getPost(User::LASTNAME) ?>">
        </label>

        <div>
            <button type="submit">Зарегистрироваться</button>
        </div>
    </form>
</div>
