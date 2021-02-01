<?php require __DIR__ . '/vendor/autoload.php';
require $_SERVER['DOCUMENT_ROOT'] . '/app/config/constants.php';
require SITE_DIR . '/app/config/database.php';

use App\Core\Application;
session_start();
$application = Application::getInstance();
$router = $application->getRouter();
$router->loadConfigfile();
if ($router->generateRoutes()) {
    $router->execute();
}
