<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Yajra\DataTables\Facades\DataTables;

class CustomerController extends Controller
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
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index(Request $request)
  {
    if (request()->ajax()) {
      $datas = User::orderBy('created_at', 'desc')
        ->whereHas('role', function ($query) {
          $query->where('code_roles', 'CST');
        })
        ->whereHas('customer')
        ->get();

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
              } else if (Str::contains(Str::lower($row['no_rumah']), Str::lower($request->get('search')))) {
                return true;
              } else if (Str::contains(Str::lower($row['address_customers']), Str::lower($request->get('search')))) {
                return true;
              }

              return false;
            });
          }
        })
        ->addColumn('action', function ($data) {
          //get module akses
          $id_menu = get_menu_id('data-customer');

          //detail
          $btn_detail = '';
          if (isAccess('read', $id_menu, Auth::user()->roles_id)) {
            $btn_detail = '<a class="dropdown-item" href="' . route('data-customer.show', $data->id) . '"><i class="fas fa-info me-1"></i> Detail</a>';
          }

          //edit
          $btn_edit = '';
          if (isAccess('update', $id_menu, Auth::user()->roles_id)) {
            $btn_edit = '<a class="dropdown-item" href="' . route('data-customer.edit', $data->id) . '"><i class="fas fa-pencil-alt me-1"></i> Edit</a>';
          }

          //delete
          $btn_hapus = '';
          if (isAccess('delete', $id_menu, Auth::user()->roles_id)) {
            $btn_hapus = '<a class="dropdown-item btn-hapus" href="javascript:void(0)" data-id="' . $data->id . '" data-nama="' . $data->name . '"><i class="fas fa-trash-alt me-1"></i> Hapus</a>';
          }

          //reset passwrod
          $btn_reset = '';
          if (isAccess('reset', $id_menu, Auth::user()->roles_id)) {
            $btn_reset = '<a class="dropdown-item btn-reset" href="javascript:void(0)" data-id="' . $data->id . '" data-nama="' . $data->name . '"><i class="fas fa-undo-alt me-1"></i> Reset Password</a>';
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
        ->addColumn('name', function ($data) {
          return $data->name;
        })
        ->addColumn('phone', function ($data) {
          return $data->phone;
        })
        ->addColumn('rt_rw', function ($data) {
          return $data->customer->rt_customers . '/' . $data->customer->rw_customers;
        })
        ->addColumn('no_rumah', function ($data) {
          return $data->customer->norumah_customers;
        })
        ->addColumn('address_customers', function ($data) {
          return mb_strimwidth($data->customer->address_customers, 0, 100, "...");;
        })
        ->addColumn('tarif', function ($data) {
          return $data->customer->tarif;
        })
        ->rawColumns([
          'action',
          'no_rumah',
          'name',
          'phone',
          'rt_rw',
          'address_customers',
          'tarif',
        ])
        ->addIndexColumn() //increment
        ->make(true);
    };

    $get_menu = get_menu_id('data-customer');
    return view('admin.pages.data-customer.index', compact('get_menu'));
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function create()
  {
    return view('admin.pages.data-customer.create');
  }

  public function rules($request)
  {
    $rule = [
      'name' => 'required|string|max:100',
      'username' => 'required|string',
      'email' => 'required|email:rfc,dns',
      'phone' => 'required|numeric|digits_between:10,12',
      'second_phone_customers' => 'nullable|numeric|digits_between:10,12',
      // 'owner_status_customers' => 'string',
      'norumah_customers' => 'required|string',
      'rt_customers' => 'required|string',
      'rw_customers' => 'required|string',
      'address_customers' => 'required|string',
      'tarif' => 'required|string',
    ];
    $pesan = [
      'name.required' => 'Nama pengguna wajib diisi!',
      'username.required' => 'Username wajib diisi!',
      'email.required' => 'Email pengguna wajib diisi!',
      'email.email' => 'Pastikan penulisan email benar dan email aktif!',
      'phone.required' => 'Nomor telepon pengguna wajib diisi!',
      'phone.numeric' => 'Nomor telepon pengguna wajib diisi dengan angka!',
      'phone.digits_between' => 'Nomor telepon pengguna harus berisikan minimal 10 angka dan maksima 12 angka!',
      'second_phone_customers.numeric' => 'Nomor telepon cadangan pengguna wajib diisi dengan angka!',
      'second_phone_customers.digits_between' => 'Nomor telepon cadangan pengguna harus berisikan minimal 10 angka dan maksima 12 angka!',
      'norumah_customers.required' => 'No rumah pengguna wajib diisi!',
      'rt_customers.required' => 'Kolom RT pengguna wajib diisi!',
      'rw_customers.required' => 'Kolom RW pengguna wajib diisi!',
      'address_customers.required' => 'Alamat penggun wajib diisi!',
      'tarif.required' => 'Tarif wajib diisi!',
    ];

    return Validator::make($request, $rule, $pesan);
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
        $check = User::where('username', $request->username)
          ->first();

        $check_customer = Customer::where('norumah_customers', $request->norumah_customers)
          ->where('rt_customers', $request->rt_customers)
          ->where('rw_customers', $request->rw_customers)
          ->where('address_customers', $request->address_customers)
          ->where('tarif', $request->tarif)
          ->first();

        if ($check != null) {
          return response()->json(['status' => false, 'pesan' => "Username sudah tersedia silahkan gunakan username yang berbeda!"], 200);
        } else if ($check_customer != null) {
          return response()->json(['status' => false, 'pesan' => "Data pelanggan sudah pernah dibuat silahkan buat pelanggan yang berbeda!"], 200);
        } else {
          $role = Role::where('code_roles', 'CST')->first();

          $post = new User();
          $post->name = $request->name;
          $post->username = $request->username;
          $post->email = $request->email;
          $post->phone = $request->phone;
          $post->roles_id = $role->id_roles;
          $post->is_publish = 1;
          $post->password = Hash::make($request->username);

          $simpan = $post->save();

          // store ke pelanggan
          $customer = new Customer();
          $customer->users_id = $post->id;
          // $customer->second_phone_customers = $request->second_phone_customers;
          // $customer->owner_status_customers = $request->owner_status_customers;
          $customer->norumah_customers = $request->norumah_customers;
          $customer->rt_customers = $request->rt_customers;
          $customer->rw_customers = $request->rw_customers;
          $customer->address_customers = $request->address_customers;
          $customer->tarif = $request->tarif;

          $simpan_customer = $customer->save();

          DB::commit();

          if ($simpan == true) {
            return response()->json([
              'status' => true,
              'pesan' => "Data pelanggan berhasil disimpan!",
            ], 200);
          } else {
            return response()->json([
              'status' => false,
              'pesan' => "Data pelanggan tidak berhasil disimpan!",
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
   * @param  \App\Models\Customer  $customer
   * @return \Illuminate\Http\Response
   */
  public function show($id)
  {
    $item = User::findOrFail($id);

    return view('admin.pages.data-customer.show', compact('item'));
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  \App\Models\Customer  $customer
   * @return \Illuminate\Http\Response
   */
  public function edit($id)
  {
    $item = User::findOrFail($id);

    return view('admin.pages.data-customer.edit', compact('item'));
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  \App\Models\Customer  $customer
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
        $post = User::findOrFail($id);

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
        $post->email = $request->email;
        $post->phone = $request->phone;

        // update ke pelanggan
        $customer = Customer::where('users_id', $id)->first();

        if ($customer->norumah_customers != $request->norumah_customers || $customer->rt_customers != $request->rt_customers || $customer->rw_customers != $request->rw_customers) {
          $check_customer = Customer::where('norumah_customers', $request->norumah_customers)
            ->where('rt_customers', $request->rt_customers)
            ->where('rw_customers', $request->rw_customers)
            ->where('address_customers', $request->address_customers)
            ->orwhere('tarif', $request->tarif)
            ->first();

          if ($check_customer == null) {
            $customer->norumah_customers = $request->norumah_customers;
            $customer->rt_customers = $request->rt_customers;
            $customer->rw_customers = $request->rw_customers;
            $customer->address_customers = $request->address_customers;
          } else {
            return response()->json(['status' => false, 'pesan' => "Data pelanggan sudah pernah dibuat silahkan buat pelanggan yang berbeda!"], 200);
          }
        }

        $customer->tarif = $request->tarif;

        $simpan = $post->save();
        $simpan_customer = $customer->save();

        DB::commit();

        if ($simpan == true) {
          return response()->json([
            'status' => true,
            'pesan' => "Data pelanggan berhasil disimpan!",
          ], 200);
        } else {
          return response()->json([
            'status' => false,
            'pesan' => "Data pelanggan tidak berhasil disimpan!",
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
   * @param  \App\Models\Customer  $customer
   * @return \Illuminate\Http\Response
   */
  // public function destroy($id)
  // {
  //   Customer::where('users_id', $id)->delete();
  //   $hapus = User::where('id', $id)->delete();

  //   if ($hapus == true) {
  //     return response()->json(['status' => true, 'pesan' => "Data pelanggan berhasil dihapus!"], 200);
  //   } else {
  //     return response()->json(['status' => false, 'pesan' => "Data pelanggan tidak berhasil dihapus!"], 400);
  //   }
  // }
  public function destroy($id){
    $customer = User::find($id);

    if ($customer) {
        $deleted = $customer->delete();

        if ($deleted) {
            return response()->json(['status' => true, 'pesan' => "Data pelanggan berhasil dihapus!"], 200);
        } else {
            return response()->json(['status' => false, 'pesan' => "Data pelanggan tidak berhasil dihapus!"], 400);
        }
    } else {
        return response()->json(['status' => false, 'pesan' => "Data pelanggan tidak ditemukan!"], 404);
    }
  }
}
