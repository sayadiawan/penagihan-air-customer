<?php

namespace App\Providers;

use Carbon\Carbon;
use App\Models\Menu;
use App\Models\UserMenuAuthorization;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
  /**
   * Register any application services.
   *
   * @return void
   */
  public function register()
  {
    //
  }

  /**
   * Bootstrap any application services.
   *
   * @return void
   */
  public function boot(Guard $auth)
  {
    // View::share('key', 'value');
    // Schema::defaultStringLength(191);
    //settimezone
    config(['app.locale' => 'id']);
    Carbon::setLocale('id');
    date_default_timezone_set('Asia/Jakarta');

    View::composer('*', function ($view) use ($auth) {
      $view->with('AuthData', $auth->user());
    });

    $menus = Menu::where('upid_menus', '0')->orderBy('name_menus', 'ASC')->get();
    $menu = new Menu();
    $userMenuAuthorization = new UserMenuAuthorization();
    //$option = Options::first(); //siinya sperti data app/company/instasi

    // View::share('option', $option);
    View::share('menus', $menus);
    View::share('menu', $menu);
    View::share('userMenuAuthorization', $userMenuAuthorization);

    Paginator::useBootstrap();
  }
}