<?php

use AppController\AppController;
use AdminController\AdminController;
use AuthController\AuthController;
use Api\AuthController\AuthController as APIAuthController;
use Api\AdminController\AdminController as APIAdminController;

switch ($route) {
    // Auth
    case '/login': AuthController::login(); break;
    case '/api/auth': APIAuthController::auth(); break;
    case '/api/auth/email': APIAuthController::loginPasswordVerify(); break;
    case '/logout': AuthController::logout(); break;

    // User Panel
    case '/':
    case '' : AppController::index(); break;

    // Admin panel
    case '/admin': AdminController::index(); break;
    case '/admin/fields': AdminController::fields(); break;
    case '/admin/offers': AdminController::offers(); break;
    case '/admin/users': AdminController::users(); break;

    // API routes
    case '/api/admin/offers': APIAdminController::getAllOffers(); break;
    case '/api/admin/offers/create': APIAdminController::createOffer(); break;
    case '/api/admin/offers/delete': APIAdminController::deleteOffer(); break;

    case '/api/admin/users': APIAdminController::getAllUsers(); break;
    case '/api/admin/users/delete': APIAdminController::deleteUser(); break;

    // Errors
    default:
        http_response_code(404);
        return view('errors/404');
        break;
}