<?php

require_once "../vendor/autoload.php";

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\{ServerRequestFactory, Response};
use CodeceptionCuriosity\Controller;

$router = new League\Route\Router();
$router->map('GET', '/', [Controller\IndexController::class, 'homeAction']);
$router->map('POST', '/login', [Controller\LoginController::class, 'loginAction']);
$router->map('GET', '/login/failed', [Controller\LoginController::class, 'failedAction']);

$request = ServerRequestFactory::fromGlobals();
$response = $router->dispatch($request);

http_response_code($response->getStatusCode());
foreach ($response->getHeaders() as $name => $values) {
    foreach ($values as $value) {
        header(sprintf('%s: %s', $name, $value), false);
    }
}

echo $response->getBody();
