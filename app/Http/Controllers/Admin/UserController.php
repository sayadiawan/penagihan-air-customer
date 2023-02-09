<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Yajra\DataTables\Facades\DataTables;

class UserController extends Controller
{
  public function __construct()
  {
    $this->middleware('auth');
  }

  /**
   * Display a listing of the resource.
   * @return Renderable
   */
  public function index(Request $request)
  {
    if (request()->ajax()) {
      $datas = User::orderBy('created_at', 'DESC')->get();

      return DataTables::of($datas)
        ->filter(function ($instance) use ($request) {
          if (!empty($request->get('search'))) {
            $instance->collection = $instance->collection->filter(function ($row) use ($request) {
              if (Str::contains(Str::lower($row['name']), Str::lower($request->get('search')))) {
                return true;
              } else if (Str::contains(Str::lower($row['username']), Str::lower($request->get('search')))) {
                return true;
              } else if (Str::contains(Str::lower($row['phone']), Str::lower($request->get('search')))) {
                return true;
              } else if (Str::contains(Str::lower($row['set_role']), Str::lower($request->get('search')))) {
                return true;
              } else if (Str::contains(Str::lower($row['set_status']), Str::lower($request->get('search')))) {
                return true;
              }

              return false;
            });
          }
        })
        ->addColumn('action', function ($data) {
          //get module akses
          $id_menu = get_menu_id('user');

          //detail
          $btn_detail = '';
          if (isAccess('detail', $id_menu, Auth::user()->roles_id)) {
            $btn_detail = '<a class="dropdown-item" href="' . route('user.show', $data->id) . '"><i class="fas fa-info me-1"></i> Detail</a>';
          }

          //edit
          $btn_edit = '';
          if (isAccess('update', $id_menu, Auth::user()->roles_id)) {
            $btn_edit = '<a class="dropdown-item" href="' . route('user.edit', $data->id) . '"><i class="fas fa-pencil-alt me-1"></i> Edit</a>';
          }

          //delete
          $btn_hapus = '';
          if (isAccess('delete', $id_menu, Auth::user()->roles_id)) {
            $btn_hapus = '<a class="dropdown-item btn-hapus" href="javascript:void(0)" data-id="' . $data->id . '" data-nama="' . $data->name . '"><i class="fas fa-trash-alt me-1"></i> Hapus</a>';
          }

          //reset passwrod
          $btn_reset = '';
          if (isAccess('reset', $id_menu, Auth::user()->roles_id)) {
            $btn_reset = '<a class="dropdown-item btn-reset" href="javascript:void(0)" data-id="' . $data->id . '" data-nama="' . $data->nama . '"><i class="fas fa-undo-alt me-1"></i> Reset Password</a>';
          }

          return '
              <div class="d-inline-block">
                <a href="javascript:;" class="btn btn-sm btn-icon dropdown-toggle hide-arrow" data-bs-toggle="dropdown"
                  aria-expanded="false">
                  <i class="bx bx-dots-vertical-rounded"></i>
                </a>

                <div class="dropdown-menu dropdown-menu-end m-0" style="">
                  ' . $btn_detail . '
                  ' . $btn_edit . '
                  ' . $btn_hapus . '
                  ' . $btn_reset . '
                </div>
              </div>
          ';
        })
        ->addColumn('set_status', function ($data) {
          if ($data->is_publish == "1") {
            $btn = "success";
            $status = "Aktif";
          } else {
            $btn = "danger";
            $status = "Tidak Aktif";
          }

          $set_status = '<button type="button" class="btn btn-sm btn-' . $btn . ' btn-status" data-val="' . $data->is_publish . '" data-id="' . $data->id . '" data-nama="' . $data->nama . '">' . $status . '</button>';

          return $set_status;
        })
        ->addColumn('set_role', function ($data) {
          return $data->role->name_roles ?? "";
        })
        ->rawColumns(['action', 'set_status', 'set_role'])
        ->addIndexColumn() //increment
        ->make(true);
    };

    $get_menu = get_menu_id('user');
    return view('admin.pages.user.index', compact('get_menu'));
  }

  public function rules($request)
  {
    $rule = [
      'name' => 'required|string|max:100',
      'username' => 'required|string',
      'email' => 'required|email:rfc,dns',
      'phone' => 'required|numeric|digits_between:10,12',
      'roles_id' => 'required',
      'is_publish' => 'required',
    ];
    $pesan = [
      'name.required' => 'Nama pengguna wajib diisi!',
      'username.required' => 'Username wajib diisi!',
      'email.required' => 'Email pengguna wajib diisi!',
      'phone.required' => 'Nomor telepon pengguna wajib diisi!',
      'roles_id.required' => 'Role akses wajib diisi!',
      'is_publish.required' => 'Status akun wajib diisi!',
    ];

    return Validator::make($request, $rule, $pesan);
  }

  /**
   * Show the form for creating a new resource.
   * @return Renderable
   */
  public function create()
  {
    $roles = Role::orderBy('name_roles')->get();

    return view('admin.pages.user.create', compact('roles'));
  }

  /**
   * Store a newly created resource in storage.
   * @param Request $request
   * @return Renderable
   */
  public function store(Request $request)
  {
    $validator = $this->rules($request->all());

    if ($validator->fails()) {
      return response()->json(['status' => false, 'pesan' => $validator->errors()]);
    } else {
      DB::beginTransaction();

      try {
        $check = User::where('username', $request->username)
          ->first();

        if ($check != null) {
          return response()->json(['status' => false, 'pesan' => "Username sudah tersedia silahkan gunakan username yang berbeda!"], 200);
        } else {
          $post = new User();
          $post->name = $request->name;
          $post->username = $request->post('username');
          $post->email = $request->post('email');
          $post->phone = $request->post('phone');
          $post->roles_id = $request->post('roles_id');
          $post->is_publish = $request->post('is_publish');
          $post->password = Hash::make('mapsline');

          $simpan = $post->save();

          DB::commit();

          if ($simpan == true) {
            return response()->json([
              'status' => true,
              'pesan' => "Data pengguna berhasil disimpan!",
            ], 200);
          } else {
            return response()->json([
              'status' => false,
              'pesan' => "Data pengguna tidak berhasil disimpan!",
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
   * Show the specified resource.
   * @param int $id
   * @return Renderable
   */
  public function show($id)
  {
    $data = User::find($id);
    $role = Role::orderBy('name_roles')->get();

    return view('admin.pages.user.show', [
      'get_data' => $data,
      'role' => $role,
    ]);
  }

  /**
   * Show the form for editing the specified resource.
   * @param int $id
   * @return Renderable
   */
  public function edit($id)
  {
    $data = User::find($id);
    $roles = Role::orderBy('name_roles')->get();

    return view('admin.pages.user.edit', ['get_data' => $data, 'roles' => $roles]);
  }

  /**
   * Update the specified resource in storage.
   * @param Request $request
   * @param int $id
   * @return Renderable
   */
  public function update(Request $request, $id)
  {
    $validator = $this->rules($request->all());

    if ($validator->fails()) {
      return response()->json(['status' => false, 'pesan' => $validator->errors()]);
    } else {
      DB::beginTransaction();

      try {
        $post = User::find($id);

        if ($post->username != $request->username) {
          $check = User::where('username', $request->username)
            ->first();

          if ($check == null) {
            $post->username = $request->username;
          } else {
            return response()->json(['status' => false, 'pesan' => 'Username ' . $request->username . ' telah tersedia. Silahkan gunakan username lainnya.']);
          }
        }

        $post->name = $request->name;
        $post->email = $request->post('email');
        $post->phone = $request->post('phone');
        $post->roles_id = $request->post('roles_id');
        $post->is_publish = $request->post('is_publish');

        $simpan = $post->save();

        DB::commit();

        if ($simpan == true) {
          return response()->json([
            'status' => true,
            'pesan' => "Data pengguna berhasil disimpan!",
          ], 200);
        } else {
          return response()->json([
            'status' => false,
            'pesan' => "Data pengguna tidak berhasil disimpan!",
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
   * @param int $id
   * @return Renderable
   */
  public function destroy($id)
  {
    $hapus = User::destroy($id);

    //jika data berhasil dihapus, akan kembali ke halaman utama
    if ($hapus) {
      return response()->json(['status' => true]);
    } else {
      return response()->json(['status' => false]);
    }
  }

  //reset password
  public function ResetPass($id)
  {
    $set = User::findOrFail($id);
    $set->password = Hash::make($set->username);
    $set->save();
    return response()->json(true);
  }

  //ganti status
  public function ChangeStatus($id, $val)
  {
    $set = User::find($id);

    if ($val == "1") {
      $set->is_publish = "0";
    } else {
      $set->is_publish = "1";
    }

    $set->save();

    return response()->json(true);
  }

  public function getUsersBySelect2(Request $request)
  {
    $search = $request->search;

    if ($search == '') {
      $data = User::orderby('name', 'asc')
        ->select('id', 'name', 'email')
        ->limit(10)
        ->get();
    } else {
      $data = User::orderby('name', 'asc')
        ->select('id', 'name', 'email')
        ->where('name', 'like', '%' . $search . '%')
        ->orwhere('username', 'like', '%' . $search . '%')
        ->orwhere('email', 'like', '%' . $search . '%')
        ->limit(10)
        ->get();
    }

    $response = array();
    foreach ($data as $item) {
      $response[] = array(
        "id" => $item->id,
        "text" => $item->name,
      );
    }

    return response()->json($response);
  }
}
