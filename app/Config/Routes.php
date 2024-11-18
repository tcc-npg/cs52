<?php



use App\Controllers\MonitoringSystem;

use App\Controllers\CurriculumController;
use App\Controllers\InventorySystem\DashboardController;
use App\Controllers\SettingsController;
// use App\Controllers\CurriculumController;
// use App\Controllers\InventorySystem\DashboardController;
// use App\Controllers\SettingsController;

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
$routes->group(
    'students',
    ['filter' => AdminsOnly::class],
    static function ($routes) {
        $routes->get('profile/(:num)', [UserController::class, 'index'], ['as' => 'students.profile.index']);
        $routes->get('list/(:alphanum)', [StudentsController::class, 'list'], [
            'as' => 'students.list',
        ]);


        $routes->get('profile/(:num)', [UserController::class, 'index'], ['as' => 'students.profile.index']);
        $routes->get('list/(:alphanum)', [StudentsController::class, 'list'], [
            'as' => 'students.list',
        ]);
    }
);

// inventory system
$routes->group(
    'inventory',
    ['filter' => AdminsOnly::class],
    static function ($routes) {
        $routes->get('', [DashboardController::class, 'dashboard'], ['as' => 'inventory.dashboard']);

    }
);

// admin functions

$routes->group(
    'settings',
    ['filter' => AdminsOnly::class],
    static function ($routes) {
        $routes->get('/', [SettingsController::class, 'index'], ['as' => 'settings.index']);
        $routes->post('save', [SettingsController::class, 'save'], ['as' => 'settings.save']);
    }
);


$routes->group('curriculum', ['filter' => AdminsOnly::class], function ($routes) {
    $routes->get('/', [CurriculumController::class, 'index'], ['as' => 'curriculum.index']);

    $routes->get('new', [CurriculumController::class, 'new'], ['as' => 'cu  rriculum.new']);

    $routes->get('new', [CurriculumController::class, 'new'], ['as' => 'curriculum.new']);

    $routes->post('save', [CurriculumController::class, 'save'], ['as' => 'curriculum.save']);
    $routes->get('subjects', [CurriculumController::class, 'subjectsList'], ['as' => 'subjects.list']);
    $routes->get('subjects/update/(:num)', [CurriculumController::class, 'subjectsUpdatePage'], ['as' => 'subjects.updatePage']);
    $routes->post('subjects/update/(:num)', [CurriculumController::class, 'subjectsUpdate'], ['as' => 'subjects.update']);
    $routes->post('subjects/delete/(:num)', [CurriculumController::class, 'subjectsDelete'], ['as' => 'subjects.delete']);



});

//monitoring
$routes->group('payables', static function ($routes) {
    $routes->get('/', [MonitoringSystem::class, 'uniform'], ['as' => 'monitoring']);
    $routes->get('uniform', [MonitoringSystem::class, 'uniform'], ['as' => 'monitoring.uniform']);
    $routes->post('addStudentInUniform', [MonitoringSystem::class, 'addStudentInUniform'], ['as' => 'monitoring.addStudentInUniform']);
    $routes->post('updateStudentInfo/(:num)/(:num)', [MonitoringSystem::class, 'updateStudentInfo'], ['as' => 'monitoring.updateStudentInfo']);
    $routes->post('deleteStudentInUniformList/(:num)', [MonitoringSystem::class, 'deleteStudentInUniformList'], ['as' => 'monitoring.deleteStudentInUniformList']);
    $routes->post('setUniformAmount', [MonitoringSystem::class, 'setUniformAmount'], ['as' => 'monitoring.setUniformAmount']);

    $routes->get('modules', [MonitoringSystem::class, 'modules'], ['as' => 'monitoring.modules']);
    $routes->post('addModule', [MonitoringSystem::class, 'addModule'], ['as' => 'monitoring.addModule']);
    $routes->get('studentsList/(:num)/(:segment)', [MonitoringSystem::class, 'studentsList'], ['as' => 'monitoring.studentsList']);
    $routes->get('listSubjects', [MonitoringSystem::class, 'listSubjects'], ['as' => 'monitoring.listSubjects']);
    $routes->post('deleteModule', [MonitoringSystem::class, 'deleteModule'], ['as' => 'monitoring.deleteModule']);
    $routes->post('updateStudentModuleStatus/(:num)/(:num)', [MonitoringSystem::class, 'updateStudentModuleStatus'], ['as' => 'monitoring.updateStudentModuleStatus']);
    $routes->POST('deleteStudentInModuleList/(:num)', [MonitoringSystem::class, 'deleteStudentInModuleList'], ['as' => 'monitoring.deleteStudentInModuleList']);
    $routes->post('addStudentInModuleList', [MonitoringSystem::class, 'addStudentInModuleList'], ['as' => 'monitoring.addStudentInModuleList']);


    $routes->get('otherPayables', [MonitoringSystem::class, 'otherPayables'], ['as' => 'monitoring.otherPayables']);
    $routes->post('addNewPayable', [MonitoringSystem::class, 'addNewPayable'], ['as' => 'monitoring.addNewPayable']);
    $routes->get('payeeList/(:num)', [MonitoringSystem::class, 'payeeList'], ['as' => 'monitoring.payeeList']);
    $routes->post('updatePayeeInfo/(:num)/(:num)', [MonitoringSystem::class, 'updatePayeeInfo'], ['as' => 'monitoring.updatePayeeInfo']);
    $routes->post('deleteOtherPayable', [MonitoringSystem::class, 'deleteOtherPayable'], ['as' => 'monitoring.deleteOtherPayable']);
    $routes->POST('deleteStudentInPayableList/(:num)/(:num)', [MonitoringSystem::class, 'deleteStudentInPayableList'], ['as' => 'monitoring.deleteStudentInPayableList']);
    $routes->post('addStudentInPayableList', [MonitoringSystem::class, 'addStudentInPayableList'], ['as' => 'monitoring.addStudentInPayableList']);


    $routes->get('viewData', [MonitoringSystem::class, 'viewData'], ['as' => 'monitoring.viewData']);

});