<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ProfileCompany;
use App\Models\ProfileCompanyBank;
use App\Models\ProfileCompanyContactDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class ProfileCompanyController extends Controller
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
  public function companyProfileAccount()
  {
    $item = ProfileCompany::orderBy('created_at', 'desc')
      ->limit(1)
      ->first();

    return view('admin.pages.profile-company.index', compact('item'));
  }

  public function rules($request)
  {
    $rule = [
      'logo_profile_companys' => 'nullable|max:2000|mimes:jpg,png',
    ];

    $pesan = [
      'logo_profile_companys.max' => 'Maksimal upload logo kecil file hanya 2Mb saja!',
      'logo_profile_companys.mimes' => 'Format file upload logo kecil hanya png, atau jpg saja!',
    ];

    return Validator::make($request, $rule, $pesan);
  }

  public function storeCompanyProfileAccount(Request $request)
  {
    $validator = $this->rules($request->all());

    if ($validator->fails()) {
      return response()->json(['status' => false, 'pesan' => $validator->errors()]);
    } else {
      DB::beginTransaction();

      try {
        $post = ProfileCompany::where('id_profile_companys', $request->id_profile_companys)->first();

        if (!isset($post)) {
          $post = new ProfileCompany();
        }

        $post->name_profile_companys = $request->name_profile_companys;
        $post->penanggungjawab_profile_companys = $request->penanggungjawab_profile_companys;
        $post->address_profile_companys = $request->address_profile_companys;
        $post->kelurahan_profile_companys = $request->kelurahan_profile_companys;
        $post->kecamataan_profile_companys = $request->kecamataan_profile_companys;
        $post->kota_profile_companys = $request->kota_profile_companys;
        $post->provinsi_profile_companys = $request->provinsi_profile_companys;

        // pembuatan kop
        $post->type_kop_profile_companys = $request->type_kop_profile_companys;

        // cek kondsi tipe yang dipilih
        if ($request->type_kop_profile_companys == 'text') {
          $validate = Validator::make($request->all(), [
            'kop_text_profile_companys' => 'required|string',
          ], [
            'kop_text_profile_companys.required' => 'Text kop tidak boleh kosong!',
          ]);

          if ($validate->fails()) {
            return response()->json(['status' => false, 'pesan' => $validate->errors()]);
          } else {
            $post->kop_text_profile_companys = $request->post('kop_text_profile_companys');

            if (Storage::disk('public')->exists($post->kop_image_profile_companys)) {
              Storage::disk('public')->delete($post->kop_image_profile_companys);
            }

            $post->kop_image_profile_companys = null;
          }
        }

        if ($request->type_kop_profile_companys == 'image') {
          if ($request->hasFile('kop_image_profile_companys')) {
            $validate = Validator::make($request->all(), [
              'kop_image_profile_companys' => 'max:2048|mimes:png,jpeg,gif|required',
            ], [
              'kop_image_profile_companys.required' => 'File tidak boleh kosong!',
              'kop_image_profile_companys.max' => 'File tidak boleh lebih dari 2Mb!',
              'kop_image_profile_companys.mimes' => 'File format hanya .png, .jpeg, atau .gif!',
            ]);

            if ($validate->fails()) {
              return response()->json(['status' => false, 'pesan' => $validate->errors()]);
            } else {
              if (Storage::disk('public')->exists($post->kop_image_profile_companys)) {
                Storage::disk('public')->delete($post->kop_image_profile_companys);
              }

              $post->kop_image_profile_companys = $request->file('kop_image_profile_companys')->store('user-kop-setting', 'public');
              $post->kop_text_profile_companys = null;
              $simpan = $post->save();
            }
          } else {
            if (Storage::disk('public')->exists($post->kop_image_profile_companys)) {
              Storage::disk('public')->delete($post->kop_image_profile_companys);
            }

            $post->kop_text_profile_companys = null;
          }
        }

        if ($request->hasFile('logo_profile_companys')) {
          if (Storage::disk('public')->exists($post->logo_profile_companys)) {
            Storage::disk('public')->delete($post->logo_profile_companys);
          }

          $post->logo_profile_companys = $request->file('logo_profile_companys')->store('profile-company', 'public');
        }

        $simpan = $post->save();

        DB::commit();

        if ($simpan == true) {
          return response()->json(['status' => true, 'pesan' => "Data perusahaan berhasil disimpan!"], 200);
        } else {
          return response()->json(['status' => false, 'pesan' => "Data perusahaan tidak berhasil disimpan!"], 200);
        }
      } catch (\Exception $e) {
        DB::rollback();

        return response()->json(['status' => false, 'pesan' => $e->getMessage()], 200);
      }
    }
  }

  public function companyBankAccount()
  {
    $item = ProfileCompany::orderBy('created_at', 'desc')
      ->limit(1)
      ->first();

    return view('admin.pages.profile-company.bank-account', compact('item'));
  }

  public function storeCompanyBankAccount(Request $request)
  {
    $validator = $this->rules($request->all());

    if ($validator->fails()) {
      return response()->json(['status' => false, 'pesan' => $validator->errors()]);
    } else {
      DB::beginTransaction();

      try {
        $post = ProfileCompany::where('id_profile_companys', $request->id_profile_companys)->first();

        if (!isset($post)) {
          $post = new ProfileCompany();
        }

        $simpan = $post->save();

        ProfileCompanyBank::where('profile_companys_id', $request->id_profile_companys)->delete();

        if (count($request->accountname_profile_company_banks) > 0) {
          for ($i = 0; $i < count($request->accountname_profile_company_banks); $i++) {
            $post_company_bank = new ProfileCompanyBank();
            $post_company_bank->profile_companys_id = $post->id_profile_companys;
            $post_company_bank->accountname_profile_company_banks = $request->accountname_profile_company_banks[$i];
            $post_company_bank->accountnumber_profile_company_banks = $request->accountnumber_profile_company_banks[$i];
            $post_company_bank->bankname_profile_company_banks = $request->bankname_profile_company_banks[$i];

            $post_company_bank->save();
          }
        }

        DB::commit();

        if ($simpan == true) {
          return response()->json(['status' => true, 'pesan' => "Data perusahaan berhasil disimpan!"], 200);
        } else {
          return response()->json(['status' => false, 'pesan' => "Data perusahaan tidak berhasil disimpan!"], 200);
        }
      } catch (\Exception $e) {
        DB::rollback();

        return response()->json(['status' => false, 'pesan' => $e->getMessage()], 200);
      }
    }
  }

  public function companyContactDetailAccount()
  {
    $item = ProfileCompany::orderBy('created_at', 'desc')
      ->limit(1)
      ->first();

    return view('admin.pages.profile-company.contact-detail', compact('item'));
  }

  public function storeCompanyContactDetailAccount(Request $request)
  {
    $validator = $this->rules($request->all());

    if ($validator->fails()) {
      return response()->json(['status' => false, 'pesan' => $validator->errors()]);
    } else {
      DB::beginTransaction();

      try {
        $post = ProfileCompany::where('id_profile_companys', $request->id_profile_companys)->first();

        if (!isset($post)) {
          $post = new ProfileCompany();
        }

        $simpan = $post->save();

        ProfileCompanyContactDetail::where('profile_companys_id', $request->id_profile_companys)->delete();

        if (count($request->name_profile_company_contact_details)) {
          for ($i = 0; $i < count($request->name_profile_company_contact_details); $i++) {
            $post_company_contact_detail = new ProfileCompanyContactDetail();
            $post_company_contact_detail->profile_companys_id = $post->id_profile_companys;
            $post_company_contact_detail->name_profile_company_contact_details = $request->name_profile_company_contact_details[$i];
            $post_company_contact_detail->phone_profile_company_contact_details = $request->phone_profile_company_contact_details[$i];

            $post_company_contact_detail->save();
          }
        }

        DB::commit();

        if ($simpan == true) {
          return response()->json(['status' => true, 'pesan' => "Data perusahaan berhasil disimpan!"], 200);
        } else {
          return response()->json(['status' => false, 'pesan' => "Data perusahaan tidak berhasil disimpan!"], 200);
        }
      } catch (\Exception $e) {
        DB::rollback();

        return response()->json(['status' => false, 'pesan' => $e->getMessage()], 200);
      }
    }
  }
}
