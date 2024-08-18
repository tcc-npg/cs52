<?php

use App\Controllers\ProfileController;
use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');

service('auth')->routes($routes);

// profile
$routes->group('profile', static function ($routes) {
    $routes->get('/', [ProfileController::class, 'index'], ['as' => 'profile.index']);
    $routes->post('update/(:num)', [ProfileController::class, 'update'], [
        'as' => 'profile.update'
    ]);
});
