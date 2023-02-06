<?php

namespace App\Http\Controllers\Admin;



use App\Http\Controllers\Controller;
use App\Models\Menu;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\UserMenuAuthorization;

class UserMenuAuthorizationController extends Controller
{
  public function __construct()
  {
    $this->middleware('auth');
  }

  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index(Request $request, $id)
  {
    $user_menu_authorizations = new UserMenuAuthorization;
    $menus = Menu::where('upid_menus', '0')->orderby('name_menus', 'ASC')->get();
    $data = Role::find($id);

    return view('admin.pages.usermenuauthorization.index', compact('data', 'menus', 'user_menu_authorizations'));
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function create()
  {
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function store(Request $request)
  {
    DB::beginTransaction();

    try {
      $simpan = false;
      $menus = $request->menu;

      foreach ($menus as $id_mdl => $mdl) {
        $post = UserMenuAuthorization::firstOrNew(['roles_id' => $request->post('roles_id'), 'menus_id' => $id_mdl]);
        $post->roles_id = $request->post('roles_id');
        $post->menus_id = $id_mdl;
        $post->action_user_menu_authorizations = $mdl;
        $post->publish_user_menu_authorizations = $request->post('publish')[$id_mdl] ?? 0;
        $simpan = $post->save();
      }

      DB::commit();

      if ($simpan == true) {
        return response()->json([
          'status' => true,
          'pesan' => "Authorization hak akses berhasil disimpan!"
        ], 200);
      } else {
        return response()->json([
          'status' => false,
          'pesan' => "Authorization hak akses tidak berhasil disimpan!"
        ], 200);
      }
    } catch (\Exception $e) {
      DB::rollback();

      return response()->json(['status' => false, 'pesan' => $e->getMessage()], 200);
    }
  }


  /**
   * Display the specified resource.
   *
   * @param  \App\Models\UserMenuAuthorization  $userMenuAuthorization
   * @return \Illuminate\Http\Response
   */
  public function show(UserMenuAuthorization $userMenuAuthorization)
  {
    //
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  \App\Models\UserMenuAuthorization  $userMenuAuthorization
   * @return \Illuminate\Http\Response
   */
  public function edit(UserMenuAuthorization $userMenuAuthorization)
  {
    //
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  \App\Models\UserMenuAuthorization  $userMenuAuthorization
   * @return \Illuminate\Http\Response
   */
  public function update(Request $request, UserMenuAuthorization $userMenuAuthorization)
  {
    //
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  \App\Models\UserMenuAuthorization  $userMenuAuthorization
   * @return \Illuminate\Http\Response
   */
  public function destroy(UserMenuAuthorization $userMenuAuthorization)
  {
    //
  }
}