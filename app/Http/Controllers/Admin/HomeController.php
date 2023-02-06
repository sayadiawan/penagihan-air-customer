<?php

namespace App\Http\Controllers\Admin;



use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
  /**
   * Create a new controller instance.
   *
   * @return void
   */
  public function __construct()
  {
    $this->middleware('auth');
  }

  /**
   * Show the application dashboard.
   *
   * @return \Illuminate\Contracts\Support\Renderable
   */
  public function index()
  {
    $is_akses = Auth::user()->role->code_roles;

    /* if ($is_akses == "SAS" || $is_akses == "ADM") {
      return view('admin.pages.home.index');
    } else {
      abort(404);
    } */

    return view('admin.pages.home.index');
  }
}
