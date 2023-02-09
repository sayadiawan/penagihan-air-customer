<?php

namespace App\Models;

use App\Traits\Uuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProfileCompanyContactDetail extends Model
{
    use HasFactory, SoftDeletes, Uuid;

    protected $primaryKey = 'id_profile_company_contact_details';
    public $incrementing = false;

    protected $fillable = [
        'profile_companys_id',
        'name_profile_company_contact_details',
        'phone_profile_company_contact_details',
    ];

    public function profilecompany()
    {
        return $this->belongsTo(ProfileCompanyBank::class, 'profile_companys_id', 'id_profile_companys')->withDefault();
    }
}
