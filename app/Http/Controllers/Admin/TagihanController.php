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
    if (request()->ajax()) {
      $datas = Tagihan::with([
        'user',
        'dataAwal'
      ])->get();

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
          $id_menu = get_menu_id('data-tagihan');

          $dataAwal = DataAwal::FindOrFail($data->data_awal_id);

          //detail
          $btn_detail = '';
          if (isAccess('read', $id_menu, Auth::user()->roles_id)) {
            $btn_detail = '<a class="dropdown-item" href="' . route('data-tagihan.show', $data->id_tagihan) . '"><i class="fas fa-info me-1"></i> Detail</a>';
            // $btn_detail = '<a class="dropdown-item" href="' . 'test' . '"><i class="fas fa-info me-1"></i> Detail</a>';
          }

          //edit
          $btn_edit = '';
          if (isAccess('update', $id_menu, Auth::user()->roles_id)) {
            $btn_edit = '<a class="dropdown-item" href="' . route('data-tagihan.edit', $data->id_tagihan) . '"><i class="fas fa-pencil-alt me-1"></i> Edit</a>';
            // $btn_edit = '<a class="dropdown-item" href="' . 'test' . '"><i class="fas fa-pencil-alt me-1"></i> Edit</a>';
          }

          //delete
          $btn_hapus = '';
          if (isAccess('delete', $id_menu, Auth::user()->roles_id)) {
            // $btn_hapus = '<a class="dropdown-item btn-hapus" href="javascript:void(0)" data-id="' . $data->id_data_awal . '" data-nama="' . $data->customer->user->name . '"><i class="fas fa-trash-alt me-1"></i> Hapus</a>';
            $btn_hapus = '<a class="dropdown-item btn-hapus" href="javascript:void(0)" data-id="' . $data->id_tagihan. '" data-name="' . $data->user->name . '"><i class="fas fa-trash-alt me-1"></i> Hapus</a>';
          }

          //reset passwrod
          $btn_reset = '';
          if (isAccess('reset', $id_menu, Auth::user()->roles_id)) {
            // $btn_reset = '<a class="dropdown-item btn-reset" href="javascript:void(0)" data-id="' . $data->id_data_awal . '" data-nama="' . $data->customer->user->name . '"><i class="fas fa-undo-alt me-1"></i> Reset Password</a>';
            $btn_reset = '<a class="dropdown-item btn-reset" href="javascript:void(0)" data-id="' . $data->id . '" data-name="' . $data->name . '"><i class="fas fa-undo-alt me-1"></i> Reset Password</a>';
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
          return $data->user->name;
        })
        ->addColumn('rt_rw', function ($data) {
          return $data->dataAwal->customer->rt_customers . '/' . $data->dataAwal->customer->rw_customers;
        })
        ->addColumn('no_rumah', function ($data) {
          return $data->dataAwal->customer->norumah_customers;
        })
        ->addColumn('address_customers', function ($data) {
          return mb_strimwidth($data->dataAwal->customer->address_customers, 0, 100, "...");;
        })
        ->addColumn('tunggakan', function ($data) {
          return $data->dataAwal->tunggakan;
        })
        ->addColumn('denda', function ($data) {
          return $data->dataAwal->denda;
        })
        ->addColumn('lain_lain', function ($data) {
          return $data->dataAwal->lain_lain;
        })
        ->addColumn('awal', function ($data) {
          return $data->dataAwal->awal;
        })
        ->addColumn('akhir', function ($data) {
          return $data->akhir;
        })
        ->addColumn('pakai', function ($data) {
          return $data->pakai;
        })
        ->addColumn('tarif', function ($data) {
          return $data->tarif;
        })
        ->addColumn('tagihan', function ($data) {
          return $data->tagihan;
        })
        ->addColumn('total_tagihan', function ($data) {
          return $data->total_tagihan;
        })
        ->addColumn('bayar', function ($data) {
          return $data->bayar;
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
          'akhir',
          'pakai',
          'tarif',
          'tagihan',
          'total_tagihan',
          'bayar'
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

          $user_id = $request->name;
          $customer = Customer::where([
            'users_id' => $user_id,
          ])->first();

          if ($customer == null) {
            return response()->json(['status' => false, 'pesan' => "Id customer tidak ditemukan"], 400);
          }

          $dataAwal = DataAwal::with([
            'customer'
          ])->where([
            'customer_id' => $customer->id_customers,
          ])->first();

          if ($dataAwal == null) {
            return response()->json(['status' => false, 'pesan' => "Id data awal tidak ditemukan"], 400);
          }

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

          // store ke pelanggan
          $dataTagihan = new Tagihan();
          $dataTagihan->user_id = $request->name;
          $dataTagihan->data_awal_id = $dataAwal->id_data_awal;
          $dataTagihan->akhir = $request->akhir;
          $dataTagihan->tarif = $request->tarif;
          $dataTagihan->tagihan = $tagihan;
          $dataTagihan->total_tagihan = $total_tagihan;
          $dataTagihan->pakai = $pakai;

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
  public function show($id_tagihan)
  {
    $item = Tagihan::findOrFail($id_tagihan);

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


  public function destroy($id_tagihan){
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
}
