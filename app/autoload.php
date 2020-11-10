<?php
session_start();

require_once 'vendor/autoload.php';
require_once 'core.php';

// Initialize .env access
$dotenv = Dotenv\Dotenv::createImmutable('./');
$dotenv->load();

// Route
$route = rtrim(explode('?', $_SERVER['REQUEST_URI'])[0], '/');

// Load config
require_once 'config.php';

// Initialize timezone
date_default_timezone_set(env('APP_TIMEZONE'));

// Load controllers
foreach (glob('controllers/*.php') as $controller) {
    require_once $controller;
}

// Load all controllers in every directory
foreach (glob('controllers/*/*.php') as $controller) {
    require_once $controller;
}

// Load models
foreach (glob('models/*.php') as $model) {
    require_once $model;
}

// Load all models in every directory
foreach (glob('models/*/*.php') as $model) {
    require_once $model;
}

// Autoload all helper funtions
foreach (glob('app/helpers/*.php') as $helper) {
    require_once $helper;
}

// Autoload all schedules
foreach (glob('app/schedules/*.php') as $schedule) {
    require_once $schedule;
}

// Load routes
require_once 'routes.php';