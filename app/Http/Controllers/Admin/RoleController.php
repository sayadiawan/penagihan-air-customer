<?php

namespace App\Http\Controllers\Admin;



use App\Http\Controllers\Controller;
use App\Models\Role;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class RoleController extends Controller
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
  public function index(Request $request)
  {
    if (request()->ajax()) {
      $datas = Role::select(['id_roles', 'name_roles', 'code_roles', 'created_at', 'updated_at'])->get();

      return Datatables::of($datas)
        ->filter(function ($instance) use ($request) {
          if (!empty($request->get('search'))) {
            $instance->collection = $instance->collection->filter(function ($row) use ($request) {
              if (Str::contains(Str::lower($row['name_roles']), Str::lower($request->get('search')))) {
                return true;
              } else if (Str::contains(Str::lower($row['code_roles']), Str::lower($request->get('search')))) {
                return true;
              }

              return false;
            });
          }
        })
        ->addColumn('action', function ($data) {
          //get module akses
          $id_menu = get_menu_id('roles');

          //detail
          $btn_role = "";
          if (isAccess('roles', $id_menu, auth()->user()->roles_id)) {
            $btn_role = '<button type="button" onclick="location.href=' . "'" . route('roles.usermenuauthorization', $data->id_roles) . "'" . ';" class="btn btn-sm btn-warning">Roles</button>';
          }

          //selalu bisa
          $btn_detail = '<a class="dropdown-item" href="' . route('roles.show', $data->id_roles) . '"><i class="fas fa-info me-1"></i> Detail</a>';

          //edit
          $btn_edit = '';
          if (isAccess('update', $id_menu, auth()->user()->roles_id)) {
            $btn_edit = '<a class="dropdown-item" href="' . route('roles.edit', $data->id_roles) . '"><i class="fas fa-pencil-alt me-1"></i> Edit</a>';
          }

          //delete
          $btn_hapus = '';
          if (isAccess('delete', $id_menu, auth()->user()->roles_id)) {
            $btn_hapus = '<a class="dropdown-item btn-hapus" href="javascript:void(0)" data-id="' . $data->id_roles . '" data-nama="' . $data->name_roles . '"><i class="fas fa-trash-alt me-1"></i> Hapus</a>';
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
                </div>
              </div>
          ';
        })
        ->addColumn('set_tgl', function ($data) {
          return $data->updated_at != null ? fdate($data->updated_at, 'HHDDMMYYYY') : fdate($data->created_at, 'HHDDMMYYYY');
        })
        ->addColumn('authorization', function ($data) {
          $id_menu = get_menu_id('roles');

          //detail
          $btn_role = "";
          if (isAccess('roles', $id_menu, auth()->user()->roles_id)) {
            $btn_role = '<button type="button" onclick="location.href=' . "'" . route('roles.usermenuauthorization', $data->id_roles) . "'" . ';" class="btn btn-sm btn-warning">Roles</button>';
          }

          return $btn_role;
        })
        ->rawColumns(['action', 'set_tgl', 'authorization'])
        ->addIndexColumn() //increment
        ->make(true);
    };

    $get_menu = get_menu_id('roles');
    return view('admin.pages.role.index', compact('get_menu'));
  }

  public function rules($request)
  {
    $rule = [
      'code_roles' => 'required',
      'name_roles' => 'required',
    ];

    $pesan = [
      'code_roles.required' => 'Kode role akses wajib diisi!',
      'name_roles.required' => 'Nama role akses wajib diisi!',
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
    return view('admin.pages.role.create');
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
        $check = Role::where('code_roles', $request->code_roles)
          ->first();

        if ($check != null) {
          return response()->json(['status' => false, 'pesan' => "Kode role akses sudah tersedia silahkan gunakan kode role akses yang berbeda!"], 200);
        } else {
          $post = new Role();
          $post->name_roles = $request->name_roles;
          $post->code_roles = $request->code_roles;

          $simpan = $post->save();

          DB::commit();

          if ($simpan == true) {
            return response()->json([
              'status' => true,
              'pesan' => "Data role akses berhasil disimpan!"
            ], 200);
          } else {
            return response()->json([
              'status' => false,
              'pesan' => "Data role akses tidak berhasil disimpan!"
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
   * @param  \App\Models\Role  $role
   * @return \Illuminate\Http\Response
   */
  public function show($id)
  {
    $data = Role::find($id);
    return view('admin.pages.role.show', compact('data'));
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  \App\Models\Role  $role
   * @return \Illuminate\Http\Response
   */
  public function edit($id)
  {
    $data = Role::find($id);
    return view('admin.pages.role.edit', compact('data'));
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  \App\Models\Role  $role
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
        $post = Role::find($id);

        if ($post->code_roles != $request->code_roles) {
          $check = Role::where('code_roles', $request->code_roles)
            ->first();

          if ($check == null) {
            $post->code_roles = $request->code_roles;
          } else {
            return response()->json(['status' => false, 'pesan' => 'Kode role akses ' . $request->code_roles . ' telah tersedia. Silahkan gunakan kode lainnya.']);
          }
        }

        $post->name_roles = $request->name_roles;

        $simpan = $post->save();

        DB::commit();

        if ($simpan == true) {
          return response()->json([
            'status' => true,
            'pesan' => "Data role akses berhasil disimpan!"
          ], 200);
        } else {
          return response()->json([
            'status' => false,
            'pesan' => "Data role akses tidak berhasil disimpan!"
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
   * @param  \App\Models\Role  $role
   * @return \Illuminate\Http\Response
   */
  public function destroy($id)
  {
    $hapus = Role::where('id_roles', $id)->delete();

    if ($hapus == true) {
      return response()->json(['status' => true, 'pesan' => "Data role akses berhasil dihapus!"], 200);
    } else {
      return response()->json(['status' => false, 'pesan' => "Data role akses tidak berhasil dihapus!"], 400);
    }
  }
}