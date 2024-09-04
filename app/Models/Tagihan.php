<?php

namespace App\Models;

use App\Traits\Uuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Tagihan extends Model
{
  use HasFactory, SoftDeletes, Uuid;

  protected $table = 'tagihans';
  protected $primaryKey = 'id_tagihan';

  protected $fillable = [
    'user_id',
    'data_awal_id',
    'akhir',
    'pakai',
    'tarif',
    'tagihan',
    'total_tagihan',
    'bayar',
    'bulan',
    'tahun',
    'tunggakan',
    'denda',
    'lain_lain'
  ];

  public function user()
  {
    return $this->belongsTo(User::class, 'user_id');
  }

  public function dataAwal()
  {
    return $this->belongsTo(DataAwal::class, 'data_awal_id');
  }
}
