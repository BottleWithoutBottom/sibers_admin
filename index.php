<?php require __DIR__ . '/vendor/autoload.php';
require __DIR__ . '/app/config/database.php';
/** @var array $DB_CONFIG */
use App\Core\Application;
$application = Application::getInstance();
$DATABASE = $application->getDBDriver($DB_CONFIG);
global $DATABASE;

$router = $application->getRouter();
$router->loadConfigfile();
$router->generateRoutes();