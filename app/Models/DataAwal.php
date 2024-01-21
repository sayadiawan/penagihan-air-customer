<?php

namespace App\Models;

use App\Traits\Uuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DataAwal extends Model
{
  use HasFactory, SoftDeletes, Uuid;

  protected $table = 'data_awals';
  protected $primaryKey = 'id_data_awal';

  protected $fillable = [
    'customer_id',
    'tunggakan',
    'denda',
    'lain_lain',
    'awal'
  ];

  public function customer()
  {
      return $this->belongsTo(Customer::class, 'customer_id');
  }
}
