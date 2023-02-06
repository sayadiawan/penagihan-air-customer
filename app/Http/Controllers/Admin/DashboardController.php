<?php

namespace App\Http\Controllers\Admin;


use App\Http\Controllers\Controller;
use App\Models\Menu;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
  public function __construct()
  {
    $this->middleware('auth');
  }

  /**
   * Display a listing of the resource.
   * @return Renderable
   */
  public function masterdata()
  {
    $master_menus = Menu::where('upid_menus', '9a7773d3-d090-4586-86eb-4a8c3804d199')->get();
    $title = "Master Data";
    return view('admin.pages.dashboard.masterdata', compact('master_menus', 'title'));
  }

  public function usermanagement()
  {
    $master_menus = Menu::where('upid_menus', '92b34539-1fc4-48d4-a97e-c5c9ec3e6d05')->get();
    $title = "User Management";
    return view('admin.pages.dashboard.masterdata', compact('master_menus', 'title'));
  }

  public function publicpage()
  {
    $master_menus = Menu::where('upid_menus', '9d157a79-dd73-4032-9eec-732d8ffa3ced')->get();
    $title = "Public Page";
    return view('admin.pages.dashboard.masterdata', compact('master_menus', 'title'));
  }
}
