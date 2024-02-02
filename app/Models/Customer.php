<?php

namespace App\Models;

use App\Traits\Uuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Customer extends Model
{
  use HasFactory, SoftDeletes, Uuid;

  protected $primaryKey = 'id_customers';
  public $incrementing = false;

  protected $fillable = [
    'users_id',
    'norumah_customers',
    'rt_customers',
    'rw_customers',
    'address_customers',
    'tarif',
  ];

  public function user()
  {
    return $this->belongsTo(User::class, 'users_id', 'id')->withDefault();
  }
  public function dataAwal()
  {
    return $this->hasOne(DataAwal::class, 'customer_id');
  }
}
