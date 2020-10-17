<?php
require_once 'vendor/autoload.php';
require_once 'core.php';

// Initialize .env access
$dotenv = Dotenv\Dotenv::createImmutable('./');
$dotenv->load();

// Load config
require_once 'config.php';

// Load controllers
foreach (glob('controllers/*.php') as $controller) {
    require_once $controller;
}

// Load models
foreach (glob('models/*.php') as $model) {
    require_once $model;
}

// Load routes
require_once 'routes/web.php';
require_once 'routes/api.php';