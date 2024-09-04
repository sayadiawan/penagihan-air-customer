<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\DataAwal;
use App\Models\Tagihan;
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
use PDF;

class TagihanController extends Controller
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

    $user = auth()->user();

    $roleCode = $user->role ? $user->role->code_roles : null;
    if (request()->ajax()) {
      $tahun_now =  Carbon::now()->year;
      $bulan_now =  Carbon::now()->month;
      $bulan_select = $request->month_filter;
      $tahun_select =  $request->year_filter;


      $user = auth()->user();

      $roleCode = $user->role ? $user->role->code_roles : null;

      if ((int)$tahun_now == (int)$tahun_select && (int)$bulan_now == (int)$bulan_select) {
        if ($roleCode == 'SAS' || $roleCode == 'ADM') {
          // Admin dan Superadmin bisa melihat semua data
          $all_customer = Customer::leftJoin('tagihans', function ($join) use ($bulan_select, $tahun_select) {
            $join->on('tagihans.user_id', '=', 'customers.users_id')
              ->where('tagihans.bulan', '=', (int)$bulan_select)
              ->where('tagihans.tahun', '=', (int)$tahun_select)
              ->whereNull('tagihans.deleted_at');
          })
            ->join('users', function ($join) {
              $join->on('users.id', '=', 'customers.users_id')
                ->whereNull('users.deleted_at');
            })
            ->whereNull('customers.deleted_at')
            ->selectRaw("users.*, tagihans.*, customers.*, CONCAT(rt_customers, '/', rw_customers) as rt_rw, 
            CASE 
                WHEN tagihans.bayar IS NOT NULL THEN 'Tertagih' 
                ELSE 'Belum Tertagih' 
            END as statustagihan")
            ->get();
        } else {
          // Jika Customer, hanya tampilkan data pelanggan yang login
          $user_id = $user->id;

          $all_customer = Customer::leftjoin('tagihans', function ($join) use ($bulan_select, $tahun_select) {
            $join->on('tagihans.user_id', '=', 'customers.users_id')
              ->where('tagihans.bulan', '=', (int)$bulan_select)
              ->where('tagihans.tahun', '=', (int)$tahun_select)
              ->whereNull('tagihans.deleted_at')
              ->whereNull('customers.deleted_at');
          })
            ->join('users', function ($join) use ($bulan_select, $tahun_select) {
              $join->on('users.id', '=', 'customers.users_id')
                ->whereNull('users.deleted_at')
                ->whereNull('customers.deleted_at');
            })
            ->where('customers.users_id', '=', $user_id) // Batasi data hanya untuk pelanggan yang login
            ->whereNull('customers.deleted_at')
            ->selectRaw("users.*, tagihans.*, customers.*, CONCAT(rt_customers, '/', rw_customers) as rt_rw")

            ->get();
        }

        $datas = $all_customer;

        // dd($all_customer);
      } else {
        if ($roleCode == 'SAS' || $roleCode == 'ADM') {
          // Ambil semua data pelanggan untuk bulan/tahun selain yang sekarang
          $all_customer = Customer::leftJoin('tagihans', function ($join) use ($bulan_select, $tahun_select) {
            $join->on('tagihans.user_id', '=', 'customers.users_id')
              ->where('tagihans.bulan', '=', $bulan_select)
              ->where('tagihans.tahun', '=', $tahun_select)
              ->whereNull('tagihans.deleted_at');
          })
            ->join('users', function ($join) {
              $join->on('users.id', '=', 'customers.users_id')
                ->whereNull('users.deleted_at');
            })
            ->where(function ($query) use ($tahun_select, $bulan_select) {
              $query->whereYear('customers.created_at', '<', $tahun_select)
                ->orWhere(function ($query) use ($tahun_select, $bulan_select) {
                  $query->whereYear('customers.created_at', '=', $tahun_select)
                    ->whereMonth('customers.created_at', '<=', $bulan_select);
                });
            })
            ->whereNull('customers.deleted_at')
            ->select('users.*', 'tagihans.*', 'customers.*', DB::raw("CONCAT(rt_customers, '/', rw_customers) as rt_rw, CASE 
                WHEN tagihans.bayar IS NOT NULL THEN 'Tertagih' 
                ELSE 'Belum Tertagih' 
            END as statustagihan"))
            ->get();
        } else {
          $user_id = $user->id;

          // Ambil data pelanggan yang login untuk bulan/tahun selain yang sekarang
          $all_customer = Customer::leftJoin('tagihans', function ($join) use ($bulan_select, $tahun_select) {
            $join->on('tagihans.user_id', '=', 'customers.users_id')
              ->where('tagihans.bulan', '=', $bulan_select)
              ->where('tagihans.tahun', '=', $tahun_select)
              ->whereNull('tagihans.deleted_at');
          })
            ->join('users', function ($join) {
              $join->on('users.id', '=', 'customers.users_id')
                ->whereNull('users.deleted_at');
            })

            ->where('customers.users_id', '=', $user_id)
            ->whereNull('customers.deleted_at')
            ->select('users.*', 'tagihans.*', 'customers.*', DB::raw("CONCAT(rt_customers, '/', rw_customers) as rt_rw"))
            ->get();
        }

        // dd($bulan_select);

        // dd($all_customer);

        $datas = $all_customer;


        // dd($bulan_select);

        // dd($all_customer);
        // dd($bulan_select);
        // dd($all_customer);


      }

      // $datas->load(['tagihan' => function ($query) use ($bulan_select, $tahun_select) {
      //     $query->whereMonth('created_at', '=', (int)$bulan_select)
      //         ->whereYear('created_at', '=', (int)$tahun_select);
      // }]);
      // $query = Tagihan::with(['user', 'dataAwal']);

      //   // Check if 'month_filter' is filled and not '00' (All)
      //   if ($request->filled('month_filter') && $request->input('month_filter') !== '00') {
      //       $query->whereMonth('created_at', $request->input('month_filter'))
      //           ->whereYear('created_at', Carbon::now()->year); // Assuming you want to filter by the current year
      //   }

      //   $datas = $query->get();

      // Add filter by created_at
      // $monthFilter = $request->get('month_filter');

      //   if ($monthFilter) {
      //     $datas = $datas->filter(function ($tagihan) use ($monthFilter) {
      //         $createdAtMonth = Carbon::parse($tagihan->created_at)->format('m');
      //         return $createdAtMonth == $monthFilter;
      //     });
      // }

      // dd($datas);

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
          // $id_menu = get_menu_id('data-tagihan');

          // $dataAwal = DataAwal::FindOrFail($data->data_awal_id);

          $btn_detail = '';
          if (isset($data->pakai) && isset($data->total_tagihan)) {
            $btn_detail = '<a class="dropdown-item" href="' . route('data-tagihan.show', $data->id) . '"><i class="fas fa-info me-1"></i> Detail</a>';
          }
          // dd($btn_detail);

          $btn_input = '';
          if (empty($data->pakai) || empty($data->total_tagihan)) {
            // dd($data->id_customers);
            $btn_input = '<a class="dropdown-item" href="' . route('input-action-route', $data->id) . '"><i class="fas fa-pencil-alt me-1"></i> Input</a>';
          }
          // dd($btn_input);

          $btn_payment = '';
          if (isset($data->pakai) && isset($data->total_tagihan)) {
            // dd($data->id_customers);
            $btn_payment = '<a class="dropdown-item" href="' . route('input-payment-route', $data->id) . '"><i class="fas fa-credit-card me-1"></i> Bayar</a>';
          }
          // dd($btn_payment);

          $btn_invoice = '';
          if (isset($data->pakai) && isset($data->total_tagihan)) {
            $btn_invoice = '<a class="dropdown-item" href="' . route('tagihan.invoice', $data->id) . '"><i class="fas fa-file-invoice me-1"></i> Invoice</a>';
          }

          //detail
          // $btn_detail = '';
          // if (isAccess('read', $id_menu, Auth::user()->roles_id)) {
          //   $btn_detail = '<a class="dropdown-item" href="' . route('data-tagihan.show', $data->id_tagihan) . '"><i class="fas fa-info me-1"></i> Detail</a>';
          //   // $btn_detail = '<a class="dropdown-item" href="' . 'test' . '"><i class="fas fa-info me-1"></i> Detail</a>';
          // }

          //edit
          // $btn_edit = '';
          // if (isAccess('update', $id_menu, Auth::user()->roles_id)) {
          //   $btn_edit = '<a class="dropdown-item" href="' . route('data-tagihan.edit', $data->id_tagihan) . '"><i class="fas fa-pencil-alt me-1"></i> Edit</a>';
          //   // $btn_edit = '<a class="dropdown-item" href="' . 'test' . '"><i class="fas fa-pencil-alt me-1"></i> Edit</a>';
          // }

          //delete
          // $btn_hapus = '';
          // if (isAccess('delete', $id_menu, Auth::user()->roles_id)) {
          //   // $btn_hapus = '<a class="dropdown-item btn-hapus" href="javascript:void(0)" data-id="' . $data->id_data_awal . '" data-nama="' . $data->customer->user->name . '"><i class="fas fa-trash-alt me-1"></i> Hapus</a>';
          //   $btn_hapus = '<a class="dropdown-item btn-hapus" href="javascript:void(0)" data-id="' . $data->id_tagihan. '" data-name="' . $data->user->name . '"><i class="fas fa-trash-alt me-1"></i> Hapus</a>';
          // }

          //reset passwrod
          // $btn_reset = '';
          // if (isAccess('reset', $id_menu, Auth::user()->roles_id)) {
          //   // $btn_reset = '<a class="dropdown-item btn-reset" href="javascript:void(0)" data-id="' . $data->id_data_awal . '" data-nama="' . $data->customer->user->name . '"><i class="fas fa-undo-alt me-1"></i> Reset Password</a>';
          //   $btn_reset = '<a class="dropdown-item btn-reset" href="javascript:void(0)" data-id="' . $data->id . '" data-name="' . $data->name . '"><i class="fas fa-undo-alt me-1"></i> Reset Password</a>';
          // }

          return '
              <div class="d-inline-block">
                <a href="javascript:;" class="btn btn-sm btn-icon dropdown-toggle hide-arrow" data-bs-toggle="dropdown"
                  aria-expanded="false">
                  <i class="bx bx-dots-vertical-rounded"></i>
                </a>

                <div class="dropdown-menu dropdown-menu-end m-0" style="">
                  ' . $btn_detail . '
                  ' . $btn_input . '
                  ' . $btn_payment . '
                  ' . $btn_invoice . '
                </div>
              </div>
          ';
        })
        ->addColumn('name', function ($data) {
          return $data->name;
        })
        ->addColumn('rt_rw', function ($data) {
          return $data->rt_rw;
        })
        ->addColumn('norumah_customers', function ($data) {
          return $data->norumah_customers;
        })
        ->addColumn('pakai', function ($data) {
          return $data->pakai;
        })

        ->addColumn('total_tagihan', function ($data) {
          return $data->total_tagihan;
        })
        // ->addColumn('bulan', function ($data) {
        //   return $data->bulan;
        // })

        // ->addColumn('tahun', function ($data) {
        //   return $data->tahun;
        // })
        ->rawColumns([
          'action',
          'name',
          'rt_rw',
          'norumah_customers',
          'pakai',
          'total_tagihan',
          'bulan',
          'tahun'
        ])
        ->addIndexColumn() //increment
        ->make(true);
    };

    $get_menu = get_menu_id('data-tagihan');
    return view('admin.pages.data-tagihan.index', compact('get_menu'));
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function getTunggakan($userId)
  {
    $dataAwal = DataAwal::whereHas('customer', function ($query) use ($userId) {
      $query->where('users_id', $userId);
    })->first();

    $result = [
      'phone' => $dataAwal ? $dataAwal->customer->user->phone : null,
      'rt_customers' => $dataAwal ? $dataAwal->customer->rt_customers : null,
      'rw_customers' => $dataAwal ? $dataAwal->customer->rw_customers : null,
      'address_customers' => $dataAwal ? $dataAwal->customer->address_customers : null,
      'tunggakan' => $dataAwal ? $dataAwal->tunggakan : null,
      'denda' => $dataAwal ? $dataAwal->denda : null,
      'lain_lain' => $dataAwal ? $dataAwal->lain_lain : null,
      'awal' => $dataAwal ? $dataAwal->awal : null,
      'tarif' => $dataAwal && $dataAwal->customer ? $dataAwal->customer->tarif : null,
    ];

    return response()->json($result);
  }
  public function create()
  {
    // $datas = DataAwal::all(); // Modify this query based on your needs
    // dd($datas);
    $datas = DataAwal::get();
    $datasuser = User::get();

    return view('admin.pages.data-tagihan.create', compact('datas', 'datasuser'));
  }

  public function rules($request)
  {
    $rule = [
      'name' => 'required',
      'akhir' => 'required|string',
      'tarif' => 'required|string',
      'tagihan' => 'string',
      'total_tagihan' => 'string',
      'bayar' => 'string',
    ];
    $pesan = [
      'name.required' => 'Nama pengguna wajib diisi!',
      'akhir.required' => 'Inputkan akhir meteran',
      'tarif.required' => 'Isi tarif',
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
        $check = Tagihan::where('user_id', $request->name)->first();

        if ($check != null) {
          return response()->json(['status' => false, 'pesan' => "Username sudah tersedia silahkan gunakan username yang berbeda!"], 200);
        } else {

          $user_name = $request->name;
          $customer = Customer::whereHas('user', function ($query) use ($user_name) {
            $query->where('name', $user_name);
          })->first();

          if ($customer == null) {
            return response()->json(['status' => false, 'pesan' => "Id customer tidak ditemukan"], 400);
          }

          $dataAwal = DataAwal::with('customer')->where('customer_id', $customer->id_customers)->first();

          if ($dataAwal == null) {
            return response()->json(['status' => false, 'pesan' => "Id data awal tidak ditemukan"], 400);
          }

          // Periksa apakah ada data denda, tunggakan, dan lain-lain di tabel tagihans
          $tagihanSebelumnya = Tagihan::where('user_id', $customer->user->id)
            ->where('bulan', $request->bulan)
            ->where('tahun', $request->tahun)
            ->first();

          $denda = $tagihanSebelumnya ? intval($tagihanSebelumnya->denda) : intval($dataAwal->denda);
          $tunggakan = $tagihanSebelumnya ? intval($tagihanSebelumnya->tunggakan) : intval($dataAwal->tunggakan);
          $lain_lain = $tagihanSebelumnya ? intval($tagihanSebelumnya->lain_lain) : intval($dataAwal->lain_lain);

          $awal = intval($dataAwal->awal);
          $akhir = intval($request->akhir);
          $tarif = intval($request->tarif);

          $pakai = $awal <= $akhir ? $akhir - $awal : (9999 - $awal) + $akhir;
          $tagihan = $pakai * $tarif;
          $tagihan = $tagihan <= 0 ? 10000 : $tagihan;

          $total_tagihan = $tagihan + $denda + $tunggakan + $lain_lain;

          // Simpan data tagihan
          $dataTagihan = new Tagihan();
          $dataTagihan->user_id = $customer->user->id;
          $dataTagihan->data_awal_id = $dataAwal->id_data_awal;
          $dataTagihan->akhir = $request->akhir;
          $dataTagihan->tarif = $request->tarif;
          $dataTagihan->tagihan = $tagihan;
          $dataTagihan->total_tagihan = $total_tagihan;
          $dataTagihan->pakai = $pakai;
          $dataTagihan->bulan = $request->bulan;
          $dataTagihan->tahun = $request->tahun;
          $dataTagihan->denda = $denda;
          $dataTagihan->tunggakan = $tunggakan;
          $dataTagihan->lain_lain = $lain_lain;

          $simpan_dataTagihan = $dataTagihan->save();

          DB::commit();

          if ($simpan_dataTagihan == true) {
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
  public function show($id)
  {
    $item = User::with('customer.dataAwal')->findOrFail($id);

    return view('admin.pages.data-tagihan.show', compact('item'));
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  \App\Models\DataAwal  $customer
   * @return \Illuminate\Http\Response
   */
  public function edit($id_tagihan)
  {
    $item = Tagihan::findOrFail($id_tagihan);

    return view('admin.pages.data-tagihan.edit', compact('item'));
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  \App\Models\DataAwal  $customer
   * @return \Illuminate\Http\Response
   */

  public function update(Request $request, $id_tagihan, $id_data_awal)
  { //dd($request->all());
    $validator = $this->rules($request->all());

    if ($validator->fails()) {
      return response()->json(['status' => false, 'pesan' => $validator->errors()]);
    } else {
      DB::beginTransaction();

      try {
        $post = Tagihan::findOrFail($id_tagihan);
        //dd($post->customer->user->name);
        if ($post->dataAwal->customer->user->name != $request->name) {
          $check = Tagihan::where('name', $request->name)
            ->first();
          //dd($check);

          if ($check == null) {
            $post->dataAwal->user->name = $request->name;
          } else {
            return response()->json(['status' => false, 'pesan' => 'name ' . $request->name . ' telah tersedia. Silahkan gunakan username lainnya.']);
          }
        }

        //$post->customer->user->name = $request->name;

        // update ke pelanggan
        $dataTagihan = Tagihan::where('data_awal_id', $id_data_awal)->first();
        $dataAwal = DataAwal::where('id_data_awal', $id_data_awal)->first();

        if ($dataAwal == null) {
          return response()->json(['status' => false, 'pesan' => "Id data awal tidak ditemukan"], 400);
        }

        if ($dataTagihan->akhir != $request->akhir || $dataTagihan->tarif != $request->tarif) {
          $check_dataTagihan = Tagihan::where('akhir', $request->akhir)
            ->orwhere('tarif', $request->tarif)
            ->first();
          //dd($check_dataAwal);
          $awal = intval($dataAwal->awal);
          $akhir = intval($request->akhir);

          $tarif = intval($request->tarif);

          $pakai = $awal <= $akhir ? $akhir - $awal : (9999 - $awal) + $akhir;
          $tagihan = $pakai * $tarif;
          $tagihan = $tagihan <= 0 ? 10000 : $tagihan;

          $denda = intval($dataAwal->denda);
          $tunggakan = intval($dataAwal->tunggakan);
          $lain_lain = intval($dataAwal->lain_lain);

          // $tagihan = $pakai;
          $total_tagihan = $tagihan + $denda + $tunggakan + $lain_lain;

          $dataTagihan->akhir = $request->akhir;
          $dataTagihan->pakai = $pakai;
          $dataTagihan->tarif = $request->tarif;
          $dataTagihan->tagihan = $tagihan;
          $dataTagihan->total_tagihan = $total_tagihan;
        }

        $simpan_dataTagihan = $dataTagihan->save();

        DB::commit();

        if ($simpan_dataTagihan == true) {
          return response()->json([
            'status' => true,
            'pesan' => "Data Tagihan pelanggan berhasil disimpan!",
          ], 200);
        } else {
          return response()->json([
            'status' => false,
            'pesan' => "Data Tagihan pelanggan tidak berhasil disimpan!",
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


  public function destroy($id_tagihan)
  {
    $dataTagihan = Tagihan::find($id_tagihan);

    if ($dataTagihan) {
      $deleted = $dataTagihan->delete();

      if ($deleted) {
        return response()->json(['status' => true, 'pesan' => "Data pelanggan berhasil dihapus!"], 200);
      } else {
        return response()->json(['status' => false, 'pesan' => "Data pelanggan tidak berhasil dihapus!"], 400);
      }
    } else {
      return response()->json(['status' => false, 'pesan' => "Data pelanggan tidak ditemukan!"], 404);
    }
  }

  public function inputAction($id)
  {
    $datasuser = User::get();
    $data = User::with('customer.dataAwal')->findOrFail($id);

    return view('admin.pages.data-tagihan.create', compact('datasuser', 'data'));
  }

  public function downloadInvoice($user_id)
  {
    // dd($id);
    $tagihan = Tagihan::with(['dataAwal', 'user'])
      ->where('user_id', $user_id)
      ->firstOrFail();
    $today = \Carbon\Carbon::now()->format('F j, Y');
    $pdf = pdf::loadView('admin.pages.invoices.invoices', compact('tagihan', 'today'));
    return $pdf->download('invoice.pdf');
    return view('admin.pages.invoices.invoices', compact('tagihan'));
  }
}
