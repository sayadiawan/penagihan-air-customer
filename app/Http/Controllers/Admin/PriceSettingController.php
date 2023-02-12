<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PriceSettings;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Yajra\DataTables\Facades\DataTables;

class PriceSettingController extends Controller
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
      $datas = PriceSettings::orderBy('created_at', 'desc')
        ->get();

      return DataTables::of($datas)
        ->filter(function ($instance) use ($request) {
          if (!empty($request->get('search'))) {
            $instance->collection = $instance->collection->filter(function ($row) use ($request) {
              if (Str::contains(Str::lower($row['tarif_air_minimum']), Str::lower($request->get('search')))) {
                return true;
              } else if (Str::contains(Str::lower($row['kenaikan_tarif_perkubik']), Str::lower($request->get('search')))) {
                return true;
              } else if (Str::contains(Str::lower($row['ref_doc_price_settings']), Str::lower($request->get('search')))) {
                return true;
              }

              return false;
            });
          }
        })
        ->addColumn('action', function ($data) {
          //get module akses
          $id_menu = get_menu_id('price-settings');

          //detail
          $btn_detail = '';
          if (isAccess('read', $id_menu, Auth::user()->roles_id)) {
            $btn_detail = '<a class="dropdown-item" href="' . route('price-settings.show', $data->id_price_settings) . '"><i class="fas fa-info me-1"></i> Detail</a>';
          }

          //edit
          $btn_edit = '';
          if (isAccess('update', $id_menu, Auth::user()->roles_id)) {
            $btn_edit = '<a class="dropdown-item" href="' . route('price-settings.edit', $data->id_price_settings) . '"><i class="fas fa-pencil-alt me-1"></i> Edit</a>';
          }

          //delete
          $btn_hapus = '';
          if (isAccess('delete', $id_menu, Auth::user()->roles_id)) {
            $btn_hapus = '<a class="dropdown-item btn-hapus" href="javascript:void(0)" data-id="' . $data->id_price_settings . '" data-nama="' . $data->minimum_value_per_cubic_price_settings . '"><i class="fas fa-trash-alt me-1"></i> Hapus</a>';
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
        ->addColumn('tarif_air_minimum', function ($data) {
          return $data->minimum_value_per_cubic_price_settings != null ? 'Rp ' . rupiah_format($data->minimum_value_per_cubic_price_settings) : '-';
        })
        ->addColumn('kenaikan_tarif_perkubik', function ($data) {
          return $data->increase_in_price_per_cubic_price_settings != null ? 'Rp ' . rupiah_format($data->increase_in_price_per_cubic_price_settings) : '-';
        })
        ->addColumn('ref_doc_price_settings', function ($data) {
          $ref_doc = '';

          if (isset($data->type_ref_doc_price_settings)) {
            if ($data->type_ref_doc_price_settings == 'TEXT') {
              if (isset($data->ref_doc_price_settings)) {
                $ref_doc = substr($data->ref_doc_price_settings, 240, strlen($data->ref_doc_price_settings));
              }
            } else {
              if (isset($data->ref_doc_price_settings)) {
                $ref_doc = '<a href="' . $data->ref_doc_price_settings . '" class="btn btn-sm btn-info" target="__blank">Link Referensi</a>';
              }
            }
          }

          return $ref_doc;
        })
        ->addColumn('is_active', function ($data) {
          $is_active = '';

          if (isset($data->is_active_price_settings)) {
            if ($data->is_active_price_settings == 1) {
              $is_active = '<a href="javascript:void(0)" class="btn btn-sm rounded-pill btn-success btn-non-active-harga" data-id="' . $data->id_price_settings . '" data-nama="' . $data->minimum_value_per_cubic_price_settings . '">Harga Aktif</a>';
            } else {
              $is_active = '<a href="javascript:void(0)" class="btn btn-sm rounded-pill btn-danger btn-active-harga" data-id="' . $data->id_price_settings . '" data-nama="' . $data->minimum_value_per_cubic_price_settings . '">Harga Tidak Aktif</a>';
            }
          }

          return $is_active;
        })
        ->rawColumns([
          'action',
          'tarif_air_minimum',
          'kenaikan_tarif_perkubik',
          'ref_doc_price_settings',
          'is_active',
        ])
        ->addIndexColumn() //increment
        ->make(true);
    };

    $get_menu = get_menu_id('price-settings');
    return view('admin.pages.price-settings.index', compact('get_menu'));
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function create()
  {
    return view('admin.pages.price-settings.create');
  }

  public function rules($request)
  {
    $rule = [
      'minimum_value_per_cubic_price_settings' => 'required|numeric',
      'increase_in_price_per_cubic_price_settings' => 'required|numeric',
    ];
    $pesan = [
      'minimum_value_per_cubic_price_settings.required' => 'Harga minimum per-kubik wajib diisi!',
      'minimum_value_per_cubic_price_settings.numeric' => 'Harga minimum per-kubik wajib diisi dengan angka!',
      'increase_in_price_per_cubic_price_settings.required' => 'Penambahan harga per-kubik wajib diisi!',
      'increase_in_price_per_cubic_price_settings.numeric' => 'Penambahan harga per-kubik wajib diisi dengan angka!',
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
      return response()->json([
        'status' => false,
        'pesan' => $validator->errors(),
      ]);
    } else {
      DB::beginTransaction();

      try {
        $post = new PriceSettings();
        $post->minimum_value_per_cubic_price_settings = $request->minimum_value_per_cubic_price_settings;
        $post->increase_in_price_per_cubic_price_settings = $request->increase_in_price_per_cubic_price_settings;
        $post->type_ref_doc_price_settings = $request->type_ref_doc_price_settings;
        $post->ref_doc_price_settings = $request->ref_doc_price_settings;

        // prses setup default
        // hanya akan ada satu default aktif harga saja maka berikut logicnya
        if ($request->is_active_price_settings == '1') {
          // hapus default jika ada kode yang sudah keset
          $check_default = PriceSettings::where('is_active_price_settings', '1')->first();

          if ($check_default) {
            $check_default->is_active_price_settings = '0';
            $check_default->save();
          }

          $post->is_active_price_settings = '1';
        } else {
          $post->is_active_price_settings = '0';
        }

        $simpan = $post->save();

        DB::commit();

        if ($simpan == true) {
          return response()->json([
            'status' => true,
            'pesan' => "Data pengaturan harga berhasil dibuat!",
          ], 200);
        } else {
          return response()->json([
            'status' => false,
            'pesan' => "Data pengaturan harga tidak dapat dibuat!",
          ], 200);
        }
      } catch (\Exception $e) {
        DB::rollback();

        return response()->json([
          'status' => false,
          'pesan' => $e->getMessage(),
        ], 200);
      }
    }
  }

  /**
   * Display the specified resource.
   *
   * @param  \App\Models\PriceSettings  $priceSettings
   * @return \Illuminate\Http\Response
   */
  public function show($id)
  {
    $item = PriceSettings::findOrFail($id);
    return view('admin.pages.price-settings.show', compact('item'));
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  \App\Models\PriceSettings  $priceSettings
   * @return \Illuminate\Http\Response
   */
  public function edit($id)
  {
    $item = PriceSettings::findOrFail($id);
    return view('admin.pages.price-settings.edit', compact('item'));
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  \App\Models\PriceSettings  $priceSettings
   * @return \Illuminate\Http\Response
   */
  public function update(Request $request, $id)
  {
    $validator = $this->rules($request->all());

    // dd($request->all());

    if ($validator->fails()) {
      return response()->json([
        'status' => false,
        'pesan' => $validator->errors(),
      ]);
    } else {
      DB::beginTransaction();

      try {
        $post = PriceSettings::findOrFail($id);
        $post->minimum_value_per_cubic_price_settings = $request->minimum_value_per_cubic_price_settings;
        $post->increase_in_price_per_cubic_price_settings = $request->increase_in_price_per_cubic_price_settings;
        $post->type_ref_doc_price_settings = $request->type_ref_doc_price_settings;
        $post->ref_doc_price_settings = $request->ref_doc_price_settings;

        if ($post->is_active_price_settings != $request->is_active_price_settings) {
          // prses setup default kode tracking
          // hanya akan ada satu default kode saja maka berikut logicnya
          if ($request->is_active_price_settings == '1') {
            // hapus default jika ada kode yang sudah keset
            $check_default = PriceSettings::where('is_active_price_settings', '1')->first();

            if ($check_default) {
              $check_default->is_active_price_settings = '0';
              $check_default->save();
            }

            $post->is_active_price_settings = '1';
          } else {
            $post->is_active_price_settings = '0';
          }
        }

        $simpan = $post->save();

        DB::commit();

        if ($simpan == true) {
          return response()->json([
            'status' => true,
            'pesan' => "Data pengaturan harga berhasil disimpan!",
          ], 200);
        } else {
          return response()->json([
            'status' => false,
            'pesan' => "Data pengaturan harga tidak berhasil disimpan!",
          ], 200);
        }
      } catch (\Exception $e) {
        DB::rollback();

        return response()->json([
          'status' => false,
          'pesan' => $e->getMessage(),
        ], 200);
      }
    }
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  \App\Models\PriceSettings  $priceSettings
   * @return \Illuminate\Http\Response
   */
  public function destroy($id)
  {
    $check_active = PriceSettings::where('id_price_settings', $id)->first();

    if ($check_active->is_active_price_settings == 1) {
      $post = PriceSettings::orderBy('created_at', 'desc')
        ->limit(1)
        ->first();
      $post->is_active_price_settings = 1;
      $post->save();
    }

    $hapus = PriceSettings::where('id_price_settings', $id)->delete();

    if ($hapus == true) {
      return response()->json(['status' => true, 'pesan' => "Data setting harga berhasil dihapus!"], 200);
    } else {
      return response()->json(['status' => false, 'pesan' => "Data setting harga tidak berhasil dihapus!"], 200);
    }
  }

  public function activePriceSetting($id)
  {
    $post = PriceSettings::where('id_price_settings', $id)->first();
    $post->is_active_price_settings = 1;
    $update = $post->save();

    if ($update == true) {
      return response()->json(['status' => true, 'pesan' => "Data setting harga berhasil diaktifkan!"], 200);
    } else {
      return response()->json(['status' => false, 'pesan' => "Data setting harga tidak berhasil diaktifkan!"], 200);
    }
  }

  public function nonactivePriceSetting($id)
  {
    $post = PriceSettings::where('id_price_settings', $id)->first();
    $post->is_active_price_settings = 0;
    $update = $post->save();

    if ($update == true) {
      return response()->json(['status' => true, 'pesan' => "Data setting harga berhasil dinonaktifkan!"], 200);
    } else {
      return response()->json(['status' => false, 'pesan' => "Data setting harga tidak berhasil dinonaktifkan!"], 200);
    }
  }
}
