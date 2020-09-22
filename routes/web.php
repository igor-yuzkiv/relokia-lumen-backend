<?php

/** @var \Laravel\Lumen\Routing\Router $router */

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$router->get('/', function () use ($router) {
    $t = new \App\Repository\TicketRepository();
    dd($t->getAll());
});

$router->group(["prefix" => "api/", "middleware" => "cors"], function () use ($router) {
    $router->group(["prefix" => "auth/"], function () use ($router) {
        $router->post("login/", "Auth\LoginController@login");
        $router->post("registration/", "Auth\LoginController@registration");
    });

    $router->group(["prefix" => "user/", "middleware" => "auth"], function () use ($router) {
        $router->post("get-permissions/", "Auth\UserController@getUserPermissions");
        $router->post("get-user-list/", "Auth\UserController@getUserList");
    });

    $router->group(["prefix" => "ticket", "middleware" => "auth"], function () use ($router) {
        $router->post("get-list", "TicketController@getTicketList");
        $router->post("create", "TicketController@create");
        $router->post("get-for-edit", "TicketController@getForEdit");
    });
});
