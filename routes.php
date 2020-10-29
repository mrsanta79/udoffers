<?php

use AppController\AppController;
use AdminController\AdminController;
use AuthController\AuthController;
use Api\AppController\AppController as APIAppController;
use Api\AdminController\AdminController as APIAdminController;
use Api\AuthController\AuthController as APIAuthController;

switch ($route) {
    // Auth
    case '/login': AuthController::login(); break;
    case '/api/auth': APIAuthController::auth(); break;
    case '/api/auth/email': APIAuthController::loginPasswordVerify(); break;
    case '/api/auth/google': APIAuthController::loginWithGoogle(); break;
    case '/api/auth/facebook': APIAuthController::loginWithFacebook(); break;
    case '/logout': AuthController::logout(); break;

    // User Panel
    case '/':
    case '' : AppController::index(); break;
    case '/api/participants': APIAppController::getAllParticipants(); break;
    case '/api/participants/update': APIAppController::participate(); break;

    // Admin panel
    case '/admin': AdminController::index(); break;
    case '/admin/fields': AdminController::fields(); break;
    case '/admin/offers': AdminController::offers(); break;
    case '/admin/users': AdminController::users(); break;

    // API routes
    case '/api/admin/offers': APIAdminController::getAllOffers(); break;
    case '/api/admin/offers/create': APIAdminController::createOffer(); break;
    case '/api/admin/offers/delete': APIAdminController::deleteOffer(); break;

    case '/api/admin/cities': APIAdminController::getAllCities(); break;
    case '/api/admin/cities/create': APIAdminController::createCity(); break;
    case '/api/admin/cities/delete': APIAdminController::deleteCity(); break;

    case '/api/admin/entries': APIAdminController::getAllEntries(); break;
    case '/api/admin/entries/create': APIAdminController::createEntry(); break;
    case '/api/admin/entries/delete': APIAdminController::deleteEntry(); break;

    case '/api/admin/users': APIAdminController::getAllUsers(); break;
    case '/api/admin/users/delete': APIAdminController::deleteUser(); break;

    case '/api/admin/ad-script/update': APIAdminController::updateAdsScript(); break;

    // Errors
    default:
        http_response_code(404);
        return view('errors/404');
        break;
}