<?php

use App\Controller\AuthController;
use App\Controller\DashboardController;
use App\Controller\MeetingController;
use Dotenv\Dotenv;

require __DIR__ . '/../vendor/autoload.php';

$dotenv = Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

$dispatcher = \FastRoute\simpleDispatcher(function (FastRoute\RouteCollector $r) {
    //views
    $r->addRoute('GET', '/signup', function () {
        require __DIR__ . '/../views/signup.php';
    });
    $r->addRoute('GET', '/signin', function () {
        require __DIR__ . '/../views/login.php';
    });

    $r->addRoute('POST', '/register', [AuthController::class, 'createUser']);
    $r->addRoute('POST', '/login', [AuthController::class, 'loginUser']);
    $r->addRoute('GET', '/logout', handler: [AuthController::class, 'logout']);
    $r->addRoute('GET', '/dashboard', [DashboardController::class, 'dashboard']);
    $r->addRoute('POST', '/create-meeting', [MeetingController::class, 'createMeeting']);
    $r->addRoute('POST', '/edit-meeting', [MeetingController::class, 'editMeeting']);
    $r->addRoute('GET', '/editmeeting', [MeetingController::class, 'getMeetingData']);
    $r->addRoute('POST', '/confirmmeeting', [MeetingController::class, 'confirmMeeting']);
    $r->addRoute('DELETE', '/removemeeting', [MeetingController::class, 'removeMeeting']);
});

// Fetch method and URI from somewhere
$httpMethod = $_SERVER['REQUEST_METHOD'];
$uri = $_SERVER['REQUEST_URI'];

// Strip query string (?foo=bar) and decode URI
if (false !== $pos = strpos($uri, '?')) {
    $uri = substr($uri, 0, $pos);
}
$uri = rawurldecode($uri);

$routeInfo = $dispatcher->dispatch($httpMethod, $uri);
switch ($routeInfo[0]) {
    case FastRoute\Dispatcher::NOT_FOUND:
        // ... 404 Not Found
        break;
    case FastRoute\Dispatcher::METHOD_NOT_ALLOWED:
        $allowedMethods = $routeInfo[1];
        // ... 405 Method Not Allowed
        break;
    case FastRoute\Dispatcher::FOUND:
        $handler = $routeInfo[1];
        $vars = $routeInfo[2];

        if (is_callable($handler)) {
            $handler($vars);
        } else {
            [$class, $method] = $handler;
            $controller = new $class();
            $controller->$method();
        }
        // ... call $handler with $vars
        break;
}
