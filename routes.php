<?php

use AppController\AppController;
use AdminController\AdminController;
use AuthController\AuthController;

switch ($route) {
    // Auth
    case '/login': AuthController::login();

    // User Panel
    case '/':
    case '' : AppController::index(); break;

    // Admin panel
    case '/admin': AdminController::index(); break;
    case '/admin/fields': AdminController::fields(); break;
    case '/admin/offers': AdminController::offers(); break;
    case '/admin/users': AdminController::users(); break;

    // API routes
    case '/api/admin': echo response(false, null, 'No message'); break;

    // Errors
    default:
        http_response_code(404);
        return view('errors/404');
        break;
}