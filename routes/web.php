<?php

use App\Http\Controllers\Admin\CustomerController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\CustomerBillController;

use App\Http\Controllers\Admin\HomeController;
use App\Http\Controllers\Admin\MenuController;
use App\Http\Controllers\Admin\PriceSettingController;
use App\Http\Controllers\Admin\ProfileCompanyController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\UserAccountController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\UserMenuAuthorizationController;
use App\Http\Controllers\Auth\LoginController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use UniSharp\LaravelFilemanager\Lfm;

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
Auth::routes();

Route::get('/login', [LoginController::class, 'showLoginForm']);
Route::post('/login', [LoginController::class, 'login'])->name('login');

Route::group(['middleware' => ['web']], function () {
  Route::post('logout', [LoginController::class, 'logout'])->name('logout');
  Route::get('/', [HomeController::class, 'index'])->name('home');
  Route::get('/home', [HomeController::class, 'index']);

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

    // MASTER DATA
    // Route Company Profile
    Route::get('/profile-company', [ProfileCompanyController::class, 'companyProfileAccount']);
    Route::post('/profile-company', [ProfileCompanyController::class, 'storeCompanyProfileAccount']);

    Route::get('/profile-company/bank-account', [ProfileCompanyController::class, 'companyBankAccount']);
    Route::post('/profile-company/bank-account', [ProfileCompanyController::class, 'storeCompanyBankAccount']);

    Route::get('/profile-company/contact-detail-account', [ProfileCompanyController::class, 'companyContactDetailAccount']);
    Route::post('/profile-company/contact-detail-account', [ProfileCompanyController::class, 'storeCompanyContactDetailAccount']);

    // Route Customer
    Route::resource("data-customer", CustomerController::class);
    Route::get('/data-customer-destroy/{id}', [CustomerController::class, 'destroy']);
    Route::post('/data-customer/get-customers-by-select2', [CustomerController::class, 'getCustomersBySelect2'])->name('data-customer.get-customers-by-select2');

    // Route Price Settings
    Route::resource("price-settings", PriceSettingController::class);
    Route::get('/price-settings-destroy/{id}', [PriceSettingController::class, 'destroy']);
    Route::get('/price-settings-active/{id}', [PriceSettingController::class, 'activePriceSetting']);
    Route::get('/price-settings-nonactive/{id}', [PriceSettingController::class, 'nonactivePriceSetting']);


    // Route Customer Bill          
    Route::resource("customer-bill", CustomerBillController::class);
  });
});
