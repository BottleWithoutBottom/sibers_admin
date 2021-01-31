<?
use App\Core\Manager\UserManager;

$userManager = new UserManager();
$authorizedInfo = $userManager->authorizeByToken();
?>

<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title></title>
    <link href="<?='/public/styles/styles.css?v=' . rand()?>" rel="stylesheet" type="text/css">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
</head>
<body>
    <div class="menu">
        <a href="/">На главную</a>
        <a href="/admin/">Админ</a>
        <div class="menu-login">
            <a class="menu-login__login js-login"
               href="/user/login/"
                <?= ($authorizedInfo->id) ? 'style="display: none"' : '' ?>
            >Войти</a>
            <a class="menu-login__logout js-logout"
               href="/user/logout/"
                <?= (!$authorizedInfo->id) ? 'style="display: none"' : '' ?>>Выйти</a>
            <a class="menu-login__register js-register"
               href="/user/register/"
                <?= ($authorizedInfo->id) ? 'style="display: none"' : '' ?>
            >Регистрация</a>
        </div>

    </div>

    <?= $content ?>
