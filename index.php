<?php require __DIR__ . '/vendor/autoload.php';
require $_SERVER['DOCUMENT_ROOT'] . '/app/config/constants.php';
require SITE_DIR . '/app/config/database.php';

use App\Core\Application;
use App\Core\Manager\UserManager;
session_start();
$application = Application::getInstance();
$userManager = new UserManager();
$router = $application->getRouter();
$router->loadConfigfile();
if ($router->generateRoutes()) {
    $router->execute();
}
