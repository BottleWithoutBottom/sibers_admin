<?php require __DIR__ . '/vendor/autoload.php';
require $_SERVER['DOCUMENT_ROOT'] . '/app/config/constants.php';
require SITE_DIR . '/app/config/database.php';
/** @var array $DB_CONFIG */
use App\Core\Application;
$application = Application::getInstance();
$DATABASE = $application->getDBDriver($DB_CONFIG);
global $DATABASE;

$router = $application->getRouter();
$router->loadConfigfile();
if ($router->generateRoutes()) {
    $router->execute();
}
