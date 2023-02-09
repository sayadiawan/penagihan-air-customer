<?php

namespace App\Models;

use App\Traits\Uuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProfileCompany extends Model
{
  use HasFactory, SoftDeletes, Uuid;

  protected $primaryKey = 'id_profile_companys';
  public $incrementing = false;
  protected $table = "profile_companys";

  protected $fillable = [
    'name_profile_companys',
    'penanggungjawab_profile_companys',
    'logo_profile_companys',
    'type_kop_profile_companys',
    'kop_image_profile_companys',
    'kop_text_profile_companys',
    'address_profile_companys',
    'kelurahan_profile_companys',
    'kecamataan_profile_companys',
    'kota_profile_companys',
    'provinsi_profile_companys',
  ];

  public function profilecompanybank()
  {
    return $this->hasMany(ProfileCompanyBank::class, 'profile_companys_id', 'id_profile_companys');
  }

  public function profilecompanycontactdetail()
  {
    return $this->hasMany(ProfileCompanyContactDetail::class, 'profile_companys_id', 'id_profile_companys');
  }

  public function userpenaggungjawab()
  {
    return $this->belongsTo(User::class, 'penanggungjawab_profile_companys', 'id')->withDefault();
  }
}
