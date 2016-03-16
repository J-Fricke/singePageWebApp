<?php

use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;

$container = new League\Container\Container;
$container->share('response', Zend\Diactoros\Response::class);

$container->share('request', function () {
    return Zend\Diactoros\ServerRequestFactory::fromGlobals($_SERVER, $_GET, $_POST, $_COOKIE, $_FILES);
});

$container->share('emitter', Zend\Diactoros\Response\SapiEmitter::class);

$router = new League\Route\RouteCollection($container);

$router->map('GET', '/', 'App\Controllers\MainController::getIndex');
$router->map('GET', '/resetPassword', function() {
    header('Location: /');exit;
});
$router->map('GET', '/resetPassword/{value}', 'App\Controllers\MainController::getResetPassword');
$router->group('/api', function ($route) {
    $route->map('GET', '/login', function(ServerRequestInterface $request, ResponseInterface $response){
        return $response->withStatus(403);
    });
    $route->map('GET', '/{param}', 'App\Controllers\ApiController::apiRouter');
    $route->map('POST', '/{param}', 'App\Controllers\ApiController::apiRouter');
    $route->map('PUT', '/{param}', 'App\Controllers\ApiController::apiRouter');
});
$response = $router->dispatch($container->get('request'), $container->get('response'));

$container->get('emitter')->emit($response);