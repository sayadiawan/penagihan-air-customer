<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\DataAwal;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Yajra\DataTables\Facades\DataTables;
use Carbon\Carbon;

class DataAwalController extends Controller
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
      $query = DataAwal::with([
        'customer'
      ]);
      if ($request->filled('month_filter') && $request->input('month_filter') !== '00') {
        $query->whereMonth('created_at', $request->input('month_filter'))
            ->whereYear('created_at', Carbon::now()->year); // Assuming you want to filter by the current year
    }
    $datas = $query->get();

      //dd($datas);


      return DataTables::of($datas)
        ->filter(function ($instance) use ($request) {
          if (!empty($request->get('search'))) {
            $instance->collection = $instance->collection->filter(function ($row) use ($request) {
              if (Str::contains(Str::lower($row['name']), Str::lower($request->get('search')))) {
                return true;
              }
              return false;
            });
          }
        })
        ->addColumn('action', function ($data) {
          //get module akses
          $id_menu = get_menu_id('data-awal-pelanggan');

          $customer = Customer::FindOrFail($data->customer_id);
          $pelanggan = User::FindOrFail($customer->users_id);

          //detail
          $btn_detail = '';
          if (isAccess('read', $id_menu, Auth::user()->roles_id)) {
            $btn_detail = '<a class="dropdown-item" href="' . route('data-awal-pelanggan.show', $data->id_data_awal) . '"><i class="fas fa-info me-1"></i> Detail</a>';
            // $btn_detail = '<a class="dropdown-item" href="' . 'test' . '"><i class="fas fa-info me-1"></i> Detail</a>';
          }

          //edit
          $btn_edit = '';
          if (isAccess('update', $id_menu, Auth::user()->roles_id)) {
            $btn_edit = '<a class="dropdown-item" href="' . route('data-awal-pelanggan.edit', $data->id_data_awal) . '"><i class="fas fa-pencil-alt me-1"></i> Edit</a>';
            // $btn_edit = '<a class="dropdown-item" href="' . 'test' . '"><i class="fas fa-pencil-alt me-1"></i> Edit</a>';
          }

          //delete
          $btn_hapus = '';
          if (isAccess('delete', $id_menu, Auth::user()->roles_id)) {
            // $btn_hapus = '<a class="dropdown-item btn-hapus" href="javascript:void(0)" data-id="' . $data->id_data_awal . '" data-nama="' . $data->customer->user->name . '"><i class="fas fa-trash-alt me-1"></i> Hapus</a>';
            $btn_hapus = '<a class="dropdown-item btn-hapus" href="javascript:void(0)" data-id="' . $data->id_data_awal. '" data-name="' . $data->customer->user->name . '"><i class="fas fa-trash-alt me-1"></i> Hapus</a>';
          }

          //reset passwrod
          $btn_reset = '';
          if (isAccess('reset', $id_menu, Auth::user()->roles_id)) {
            // $btn_reset = '<a class="dropdown-item btn-reset" href="javascript:void(0)" data-id="' . $data->id_data_awal . '" data-nama="' . $data->customer->user->name . '"><i class="fas fa-undo-alt me-1"></i> Reset Password</a>';
            $btn_reset = '<a class="dropdown-item btn-reset" href="javascript:void(0)" data-id="' . $pelanggan->id . '" data-name="' . $pelanggan->name . '"><i class="fas fa-undo-alt me-1"></i> Reset Password</a>';
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
          return $data->customer->user->name;
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
        ->addColumn('tunggakan', function ($data) {
          return $data->tunggakan;
        })
        ->addColumn('denda', function ($data) {
          return $data->denda;
        })
        ->addColumn('lain_lain', function ($data) {
          return $data->lain_lain;
        })
        ->addColumn('awal', function ($data) {
          return $data->awal;
        })
        ->rawColumns([
          'action',
          'name',
          'rt_customers',
          'rw_customers',
          'norumah_customers',
          'tunggakan',
          'denda',
          'lain-lain',
          'awal',
        ])
        ->addIndexColumn() //increment
        ->make(true);
    };

    $get_menu = get_menu_id('data-awal-pelanggan');
    return view('admin.pages.data-awal.index', compact('get_menu'));
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function create()
  {
      // $datas = DataAwal::all(); // Modify this query based on your needs
      // dd($datas);
      $datas = Customer::get();

      return view('admin.pages.data-awal.create', compact('datas'));

  }

  public function rules($request)
  {
    $rule = [
      'name' => 'required',
      'tunggakan' => 'required|string',
      'denda' => 'required|string',
      'lain_lain' => 'required|string',
      'awal' => 'required|string',
    ];
    $pesan = [
      'name.required' => 'Nama pengguna wajib diisi!',
      'tunggakan.required' => 'Jika tidak ada tunggakan berikan inputan 0',
      'denda.required' => 'Jika tidak ada denda berikan inputan 0',
      'lain_lain.required' => 'Jika tidak ada lain-lain berikan inputan 0',
      'awal.required' => 'Isi awal meteran'
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
    // dd($request->all());
    if ($validator->fails()) {
      return response()->json(['status' => false, 'pesan' => $validator->errors()]);
    } else {
      DB::beginTransaction();

      try {
        // $check = User::where('username', $request->username)
        //   ->first();

        // $check_customer = Customer::where('norumah_customers', $request->norumah_customers)
        //   ->where('rt_customers', $request->rt_customers)
        //   ->where('rw_customers', $request->rw_customers)
        //   ->orwhere('address_customers', $request->address_customers)
        //   ->first();

        // $check_dataAwal = DataAwal::where('tunggakan', $request->tunggakan)
        //   ->where('denda', $request->denda)
        //   ->where('lain_lain', $request->lain_lain)
        //   ->where('awal', $request->awal)
        //   ->first();
        $check = DataAwal::where('customer_id', $request->name)->first();

        if ($check != null) {
          return response()->json(['status' => false, 'pesan' => "Username sudah tersedia silahkan gunakan username yang berbeda!"], 200);
        } else {

          // store ke pelanggan
          $dataAwal = new DataAwal();
          $dataAwal->customer_id = $request->name;
          $dataAwal->tunggakan = $request->tunggakan;
          $dataAwal->denda = $request->denda;
          $dataAwal->lain_lain = $request->lain_lain;
          $dataAwal->awal = $request->awal;

          $simpan_dataAwal = $dataAwal->save();

          DB::commit();

          if ($simpan_dataAwal == true) {
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
   * @param  \App\Models\DataAwal  $customer
   * @return \Illuminate\Http\Response
   */
  public function show($id_data_awal)
  {
    $item = DataAwal::findOrFail($id_data_awal);

    return view('admin.pages.data-awal.show', compact('item'));
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  \App\Models\DataAwal  $customer
   * @return \Illuminate\Http\Response
   */
  public function edit($id_data_awal)
  {
    $item = DataAwal::findOrFail($id_data_awal);

    return view('admin.pages.data-awal.edit', compact('item'));
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  \App\Models\DataAwal  $customer
   * @return \Illuminate\Http\Response
   */

  public function update(Request $request, $id_data_awal, $id_customers)
  { //dd($request->all());
    $validator = $this->rules($request->all());

    if ($validator->fails()) {
      return response()->json(['status' => false, 'pesan' => $validator->errors()]);
    } else {
      DB::beginTransaction();

      try {
        $post = DataAwal::findOrFail($id_data_awal);
        //dd($post->customer->user->name);
        if ($post->customer->user->name != $request->name) {
          $check = DataAwal::where('name', $request->name)
            ->first();
            //dd($check);

          if ($check == null) {
            $post->customer->user->name = $request->name;
          } else {
            return response()->json(['status' => false, 'pesan' => 'name ' . $request->name . ' telah tersedia. Silahkan gunakan username lainnya.']);
          }
        }

        //$post->customer->user->name = $request->name;

        // update ke pelanggan
        $dataAwal = DataAwal::where('customer_id', $id_customers)->first();

        if ($dataAwal->tunggakan != $request->tunggakan || $dataAwal->denda != $request->denda || $dataAwal->lain_lain != $request->lain_lain || $dataAwal->awal != $request->awal) {
          $check_dataAwal = DataAwal::where('tunggakan', $request->tunggakan)
            ->where('denda', $request->denda)
            ->where('lain_lain', $request->lain_lain)
            ->orwhere('awal', $request->awal)
            ->first();
            //dd($check_dataAwal);
            $dataAwal->tunggakan = $request->tunggakan;
            $dataAwal->denda = $request->denda;
            $dataAwal->lain_lain = $request->lain_lain;
            $dataAwal->awal = $request->awal;
        }

        $dataAwal->awal = $request->awal;

        $simpan_dataAwal = $dataAwal->save();

        DB::commit();

        if ($simpan_dataAwal == true) {
          return response()->json([
            'status' => true,
            'pesan' => "Data Awal pelanggan berhasil disimpan!",
          ], 200);
        } else {
          return response()->json([
            'status' => false,
            'pesan' => "Data Awal pelanggan tidak berhasil disimpan!",
          ], 200);
        }
      } catch (\Exception $e) {
        DB::rollback();

        return response()->json(['status' => false, 'pesan' => $e->getMessage()], 200);

        //dd($request->all());
      }
    }
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  \App\Models\DataAwal  $customer
   * @return \Illuminate\Http\Response
   */


  public function destroy($id_data_awal){
    $dataAwal = DataAwal::find($id_data_awal);

    if ($dataAwal) {
        $deleted = $dataAwal->delete();

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
