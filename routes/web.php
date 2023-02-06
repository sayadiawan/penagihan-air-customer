<?php

use App\Models\Resi;
use Illuminate\Support\Facades\Auth;

use UniSharp\LaravelFilemanager\Lfm;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Web\HomeController;
use App\Http\Controllers\Admin\AreaController;
use App\Http\Controllers\Admin\MenuController;
use App\Http\Controllers\Admin\PostController;
use App\Http\Controllers\Admin\ResiController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Admin\AgentController;
use App\Http\Controllers\Web\PostageController;


use App\Http\Controllers\Admin\DriverController;
use App\Http\Controllers\Web\OrderLogController;
use App\Http\Controllers\Admin\ServiceController;
use App\Http\Controllers\Admin\VoucherController;
use App\Http\Controllers\Web\SubscriberController;
use App\Http\Controllers\Admin\AreaAgentController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\UserAccountController;
use App\Http\Controllers\Admin\KodeTrackingController;
use App\Http\Controllers\Admin\RequestPickupController;
use App\Http\Controllers\Admin\RoutePriceLocalController;
use App\Http\Controllers\Admin\BannerInformationController;
use App\Http\Controllers\Admin\DataPickupDriverController;
use App\Http\Controllers\Admin\UpdateDataTrackingController;
use App\Http\Controllers\Admin\UserMenuAuthorizationController;
use App\Http\Controllers\Admin\RoutePriceInternationalController;
use App\Http\Controllers\Web\AreaController as WebAreaController;
use App\Http\Controllers\Web\ResiController as WebResiController;
use App\Http\Controllers\Admin\InputResiDomestikMapslineController;
use App\Http\Controllers\Admin\InputResiInternasionalMapslineController;
use App\Http\Controllers\Admin\InputResiDomestikLayananLainnyaController;
use App\Http\Controllers\Admin\InputResiInternasionalLayananLainnyaController;
use App\Http\Controllers\Admin\ResiRequestPickupController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Auth::routes();
Auth::routes(['home' => false]);

//Public Routes
Route::get('/login', [LoginController::class, 'showLoginForm']);
Route::post('/login', [LoginController::class, 'login'])->name('login');
Route::get('/', [HomeController::class, 'index'])->name('/');

Route::get('/', [HomeController::class, 'index']);

//Admin Routes
Route::middleware(['web'])->prefix('admin')->group(function () {
  Route::get('/', [App\Http\Controllers\Admin\HomeController::class, 'index'])->name('admin');
  Route::get('/home', [App\Http\Controllers\Admin\HomeController::class, 'index'])->name('home');

  Route::group(['prefix' => 'web-filemanager'], function () {
    \UniSharp\LaravelFilemanager\Lfm::routes();
  });

  Route::middleware('checkUserRole')->group(function () {
    // Route Dashboard
    Route::get('/master-data', [DashboardController::class, 'masterdata']);
    Route::get('/user-management', [DashboardController::class, 'usermanagement']);
    Route::get('/public-page', [DashboardController::class, 'publicpage']);

    // Route Menu
    Route::resource("menus", MenuController::class);
    Route::post('/menus/sort', [MenuController::class, 'sort']);
    Route::get('/menus/delete/{id}', [MenuController::class, 'destroy'])->name('menus-delete');

    // Route Roles dan Authorization
    // Route::get('/roles/', [RoleController::class, 'index']);
    Route::get('/roles/delete/{id}', [RoleController::class, 'destroy']);
    Route::get('/roles/usermenuauthorization/{id}', [UserMenuAuthorizationController::class, 'index'])->name('roles.usermenuauthorization');
    Route::post('/roles/usermenuauthorization/store', [UserMenuAuthorizationController::class, 'store'])->name('roles.usermenuauthorization.store');
    Route::resource("roles", RoleController::class);

    // Route User
    Route::resource("user", UserController::class);
    Route::get('/user-destroy/{id}', [UserController::class, 'destroy']);
    Route::get('/user-reset/{id}', [UserController::class, 'ResetPass']);
    Route::get('/user-reset-status/{id}/{val}', [UserController::class, 'ChangeStatus']);
    Route::post('/user/get-users-by-select2', [UserController::class, 'getUsersBySelect2'])->name('getUsersBySelect2');

    // Route User Account
    Route::get('/user-profile-account', [UserAccountController::class, 'userProfileAccount']);
    Route::post('/user-profile-account/{id}', [UserAccountController::class, 'storeUserProfileAccount']);
    Route::get('/user-password-account', [UserAccountController::class, 'userPasswordAccount']);
    Route::post('/user-password-account/{id}', [UserAccountController::class, 'storeUserPasswordAccount']);
  });
});
