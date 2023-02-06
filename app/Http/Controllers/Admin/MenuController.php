<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Menu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class MenuController extends Controller
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
  public function index()
  {
    $data = Menu::where('upid_menus', "0")
      ->orderBy('name_menus', 'ASC')
      ->get();

    return view('admin.pages.menu.index', compact('data'));
  }

  public function rules($request)
  {
    $rule = [
      'name_menus' => 'required|string|max:100',
      'code_menus' => 'required|string|max:15',
      'link_menus' => 'required|string',
      'icon_menus' => 'required|string|max:50',
      'action_menus' => 'required',
    ];

    $pesan = [
      'name_menus.required' => 'Nama menu wajib diisi!',
      'link_menus.required' => 'Link menu wajib diisi!',
      'icon_menus.required' => 'Icon menu wajib diisi!',
      'action_menus.required' => 'Action menu wajib diisi!',
    ];

    return Validator::make($request, $rule, $pesan);
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function create()
  {
    $menus = Menu::all()->where('upid_menus', "0");
    return view('admin.pages.menu.create', compact('menus'));
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function store(Request $request)
  {
    $validator = $this->rules($request->all());

    if ($validator->fails()) {
      return response()->json(['status' => false, 'pesan' => $validator->errors()]);
    } else {
      DB::beginTransaction();

      try {
        $check = Menu::where('code_menus', $request->code_menus)
          ->first();

        if ($check != null) {
          return response()->json(['status' => false, 'pesan' => "Kode menu sudah tersedia silahkan gunakan kode menu yang berbeda!"], 200);
        } else {
          $post = new Menu();
          $post->upid_menus = $request->post('upid_menus') ?? 0;
          $post->code_menus = $request->post('code_menus');
          $post->name_menus = $request->post('name_menus');
          $post->link_menus = $request->post('link_menus');
          $post->icon_menus = $request->post('icon_menus');
          $post->action_menus = $request->post('action_menus');
          $post->description_menus = $request->post('description_menus');

          $simpan = $post->save();

          DB::commit();

          if ($simpan == true) {
            return response()->json([
              'status' => true,
              'pesan' => "Data menu berhasil disimpan!"
            ], 200);
          } else {
            return response()->json([
              'status' => false,
              'pesan' => "Data menu tidak berhasil disimpan!"
            ], 200);
          }
        }
      } catch (\Exception $e) {
        DB::rollback();

        return response()->json(['status' => false, 'pesan' => $e->getMessage()], 200);
      }
    }
  }

  /**
   * Display the specified resource.
   *
   * @param  \App\Models\Menu  $menu
   * @return \Illuminate\Http\Response
   */
  public function show($id)
  {
    $data = Menu::find($id);
    return view('admin.pages.menu.show', compact('data'));
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  \App\Models\Menu  $menu
   * @return \Illuminate\Http\Response
   */
  public function edit($id)
  {
    $menus = Menu::all()->where('upid_menus', "0");
    $data = Menu::find($id);

    return view('admin.pages.menu.edit', compact('data', 'menus'));
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  \App\Models\Menu  $menu
   * @return \Illuminate\Http\Response
   */
  public function update(Request $request, $id)
  {
    $validator = $this->rules($request->all());

    if ($validator->fails()) {
      return response()->json(['status' => false, 'pesan' => $validator->errors()]);
    } else {
      DB::beginTransaction();

      try {
        $post = Menu::find($id);

        if ($post->code_menus != $request->code_menus) {
          $check = Menu::where('code_menus', $request->code_menus)
            ->first();

          if ($check == null) {
            $post->code_menus = $request->code_menus;
          } else {
            return response()->json(['status' => false, 'pesan' => 'Kode menu ' . $request->code_menus . ' telah tersedia. Silahkan gunakan kode lainnya.']);
          }
        }

        $post->upid_menus = $request->post('upid_menus') ?? 0;
        $post->name_menus = $request->post('name_menus');
        $post->link_menus = $request->post('link_menus');
        $post->icon_menus = $request->post('icon_menus');
        $post->action_menus = $request->post('action_menus');
        $post->description_menus = $request->post('description_menus');

        $simpan = $post->save();

        DB::commit();

        if ($simpan == true) {
          return response()->json([
            'status' => true,
            'pesan' => "Data menu berhasil disimpan!"
          ], 200);
        } else {
          return response()->json([
            'status' => false,
            'pesan' => "Data menu tidak berhasil disimpan!"
          ], 200);
        }
      } catch (\Exception $e) {
        DB::rollback();

        return response()->json(['status' => false, 'pesan' => $e->getMessage()], 200);
      }
    }
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  \App\Models\Menu  $menu
   * @return \Illuminate\Http\Response
   */
  public function destroy($id)
  {
    $hapus = Menu::where('id_menus', $id)->delete();

    if ($hapus == true) {
      return response()->json(['status' => true, 'pesan' => "Data menu berhasil dihapus!"], 200);
    } else {
      return response()->json(['status' => false, 'pesan' => "Data menu tidak berhasil dihapus!"], 400);
    }
  }

  public function sort()
  {
    // $sortData = array();
    $sort = 1;
    foreach (request('main') as $key => $main) {
      if (is_array($main)) {
        $no = 1;
        foreach ($main as $a => $b) {
          $sortData[$b]['parent'] = $key;
          $sortData[$b]['sort'] = $no;
          $no++;
        }
      } else {
        // echo $main."<br>";
        $sortData[$main]['parent'] = "0";
        $sortData[$main]['sort'] = $sort;
        $sort++;
      }
    }

    foreach ($sortData as $id => $data) {
      $id = str_replace("mdl-", "", $id);
      $parent = str_replace("mdl-", "", $data['parent']);

      $set =  Menu::find($id);
      $set->upid_menus = $parent;
      $set->save();
    }
  }
}