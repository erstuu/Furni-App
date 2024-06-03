<?php

require_once __DIR__ . "/../vendor/autoload.php";

use Restugedepurnama\Furni\App\Router;
use Restugedepurnama\Furni\Controller\HomeController;
use Restugedepurnama\Furni\Controller\UserController;
use Restugedepurnama\Furni\Controller\AdminController;
use Restugedepurnama\Furni\Middleware\MustLoginMiddleware;
use Restugedepurnama\Furni\Middleware\MustNotLoginMiddleware;

// Home Controller
Router::add("GET", "/", HomeController::class, "index", []);

// User Controller
Router::add("GET", "/users/register", UserController::class, "register", [MustNotLoginMiddleware::class]);
Router::add("POST", "/users/register", UserController::class, "postRegister", [MustNotLoginMiddleware::class]);

Router::add("GET", "/users/login", UserController::class, "login", [MustNotLoginMiddleware::class]);
Router::add("POST", "/users/login", UserController::class, "postLogin", [MustNotLoginMiddleware::class]);

Router::add("GET", "/admin", AdminController::class, "admin", [MustLoginMiddleware::class]);
Router::add("POST", "/admin", AdminController::class, "postAdmin", [MustLoginMiddleware::class]);

Router::add("GET", "/users/logout", UserController::class, "logout", [MustLoginMiddleware::class]);

Router::run();