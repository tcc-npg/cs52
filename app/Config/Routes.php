<?php

use App\Controllers\InventorySystem\DashboardController;
use App\Controllers\SettingsController;
use App\Controllers\StudentsController;
use App\Controllers\UserController;
use App\Filters\AdminsOnly;
use App\Filters\StudentAreaFilter;
use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');

service('auth')->routes($routes);

// user
$routes->group('user', static function ($routes) {
    $routes->get('/', [UserController::class, 'index'], ['as' => 'user.index']);
    $routes->get('subjects-enrolled', [UserController::class, 'subjectsEnrolled'], [
        'as' => 'user.subjects-enrolled',
        'filter' => StudentAreaFilter::class
    ]);
    $routes->post('update/(:num)', [UserController::class, 'update'], [
        'as' => 'user.update'
    ]);
});

// students
$routes->group('students',
    ['filter' => AdminsOnly::class],
    static function ($routes) {
        $routes->get('profile/(:num)', [UserController::class, 'index'], ['as' => 'students.profile.index']);
        $routes->get('list/(:alphanum)', [StudentsController::class, 'list'], [
            'as' => 'students.list',
        ]);
    });

// inventory system
$routes->group('inventory',
    ['filter' => AdminsOnly::class],
    static function ($routes) {
        $routes->get('dashboard', [DashboardController::class, 'dashboard'], ['as' => 'inventory.dashboard']);

    });

// admin functions

$routes->group('settings',
    ['filter' => AdminsOnly::class],
    static function ($routes) {
        $routes->get('/', [SettingsController::class, 'index'], ['as' => 'settings.index']);
        $routes->post('save', [SettingsController::class, 'save'], ['as' => 'settings.save']);
    });
