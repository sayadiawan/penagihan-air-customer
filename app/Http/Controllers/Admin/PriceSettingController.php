<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PriceSettings;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
            $btn_detail = '<a class="dropdown-item" href="' . route('price-settings.show', $data->id) . '"><i class="fas fa-info me-1"></i> Detail</a>';
          }

          //edit
          $btn_edit = '';
          if (isAccess('update', $id_menu, Auth::user()->roles_id)) {
            $btn_edit = '<a class="dropdown-item" href="' . route('price-settings.edit', $data->id) . '"><i class="fas fa-pencil-alt me-1"></i> Edit</a>';
          }

          //delete
          $btn_hapus = '';
          if (isAccess('delete', $id_menu, Auth::user()->roles_id)) {
            $btn_hapus = '<a class="dropdown-item btn-hapus" href="javascript:void(0)" data-id="' . $data->id . '" data-nama="' . $data->name . '"><i class="fas fa-trash-alt me-1"></i> Hapus</a>';
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
                $ref_doc = $data->ref_doc_price_settings;
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
              $is_active = '<a href="javascript:void(0)" class="btn rounded-pill bg-success btn-non-active-harga">Harga Aktif</a>';
            } else {
              $is_active = '<a href="javascript:void(0)" class="btn rounded-pill bg-danger btn-active-harga">Harga Tidak Aktif</a>';
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
    //
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function store(Request $request)
  {
    //
  }

  /**
   * Display the specified resource.
   *
   * @param  \App\Models\PriceSettings  $priceSettings
   * @return \Illuminate\Http\Response
   */
  public function show(PriceSettings $priceSettings)
  {
    //
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  \App\Models\PriceSettings  $priceSettings
   * @return \Illuminate\Http\Response
   */
  public function edit(PriceSettings $priceSettings)
  {
    //
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  \App\Models\PriceSettings  $priceSettings
   * @return \Illuminate\Http\Response
   */
  public function update(Request $request, PriceSettings $priceSettings)
  {
    //
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  \App\Models\PriceSettings  $priceSettings
   * @return \Illuminate\Http\Response
   */
  public function destroy(PriceSettings $priceSettings)
  {
    //
  }
}
