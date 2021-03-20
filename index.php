<?php

ob_start();

require_once __DIR__ . "/vendor/autoload.php";

use CoffeeCode\Router\Router;

new \App\Core\Session();

$router = new Router(url(), ":");

$router->namespace("App\Controllers");

/**
 * Home
 */
$router->get('/', "HomeController:index");
$router->post('/', "HomeController:login");

$router->get('/registar', "HomeController:create");
$router->post('/registar', "HomeController:store");

$router->get('/confirma', "HomeController:confirm");
$router->get('/obrigado/{email}', "HomeController:success");

$router->get('/esqueceu', "HomeController:forgot");
$router->post('/esqueceu', "HomeController:forgotSend");

$router->get('/recuperar/{code}', "HomeController:reset");
$router->post('/recuperar', "HomeController:resetUpdate");

$router->get('/logout', "HomeController:logout");

$router->get('/home', "HomeController:home");


$router->namespace("App\Controllers")->group("erro");
$router->get("/{errorcode}", "ErrorController:index");

$router->dispatch();

if ($router->error()) {
    $router->redirect("/erro/{$router->error()}");
}

ob_end_flush();
