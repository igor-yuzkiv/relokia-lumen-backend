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
   /* dd( (new \App\Repository\UserRepository())->getUserInfoByApiKey('$2y$10$/lV4SaQdqUr4X3CGQhZ0GOTYoiBmYErlIWiLbi6XIqxWpQ.ZzcZUi') );

    $role1 = \Spatie\Permission\Models\Role::create(["name" => "Guest"]);
    $role2 = \Spatie\Permission\Models\Role::create(["name" => "Customer"]);*/

    /**
     * @var $user \App\Models\User
     */
    $user = \App\Models\User::whereEmail("igor97w@gmail.com")->first();
    #$user->delete();
    $user->assignRole([\App\Models\User::USER_ROLE_CUSTOMER]);
});

$router->group(["prefix" => "api/", "middleware" => "cors"], function () use ($router) {
    $router->group(["prefix" => "auth/"], function () use ($router) {
        $router->post("login/", "Auth\LoginController@login");
        $router->post("registration/", "Auth\LoginController@registration");
    });

    $router->group(["prefix" => "user/", "middleware" => "auth"], function () use ($router) {
        $router->post("get-permissions/", "Auth\UserController@getUserPermissions");
    });

    $router->group(["prefix" => "ticket", "middleware" => "auth"], function () use ($router) {
        $router->post("list", "Ticket\TicketListController@index");
    });
});
