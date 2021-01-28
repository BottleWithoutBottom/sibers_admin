<?php
define(CONFIGS, $_SERVER['DOCUMENT_ROOT'] . 'app/config/');
define(BOOTSTRAP, CONFIGS . 'bootstrap.php');
define(SITE_DIR, $_SERVER['DOCUMENT_ROOT']);

define(CONTROLLER_NAMESPACE, 'App\Mvc\Controllers\\');
define(CONTROLLERS_DIR, SITE_DIR . 'app/Mvc/Controllers/');

define(MODELS_NAMESPACE, 'App\Mvc\Models\\');


define(LAYOUTS, SITE_DIR . 'app/layouts/');
define(VIEWS_DIR, SITE_DIR . 'app/Mvc/Views/');