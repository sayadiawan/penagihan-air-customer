<?php

namespace App\Models;

use App\Traits\Uuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProfileCompanyBank extends Model
{
    use HasFactory, SoftDeletes, Uuid;

    protected $primaryKey = 'id_profile_company_banks';
    public $incrementing = false;

    protected $fillable = [
        'profile_companys_id',
        'bankname_profile_company_banks',
        'accountname_profile_company_banks',
        'accountnumber_profile_company_banks',
    ];

    public function profilecompany()
    {
        return $this->belongsTo(ProfileCompanyBank::class, 'profile_companys_id', 'id_profile_companys')->withDefault();
    }
}
