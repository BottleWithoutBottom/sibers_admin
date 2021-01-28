<?php
define(CONFIGS, $_SERVER['DOCUMENT_ROOT'] . 'app/config/');
define(BOOTSTRAP, CONFIGS . 'bootstrap.php');
define(SITE_DIR, $_SERVER['DOCUMENT_ROOT']);

define(CONTROLLER_NAMESPACE, 'App\Mvc\Controllers\\');
define(CONTROLLERS_DIR, SITE_DIR . 'app/Mvc/Controllers/');