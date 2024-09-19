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

  public function generateKodeInvoice()
  {
    $prefix = 'INV';
    $date = now()->format('Ymd');

    // Mengambil invoice terakhir yang sudah dibuat pada hari yang sama
    $lastInvoice = Tagihan::whereDate('created_at', now())
      ->where('kode_invoice', 'like', $prefix . $date . '%')
      ->orderBy('user_id', 'desc')
      ->first();

    if ($lastInvoice) {
      $lastNumber = intval(substr($lastInvoice->kode_invoice, -4));
      $newNumber = str_pad($lastNumber + 1, 4, '0', STR_PAD_LEFT);
    } else {
      $newNumber = '0001';
    }

    return $prefix .  $date . $newNumber;
  }

  public function user()
  {
    return $this->belongsTo(User::class, 'user_id');
  }

  public function dataAwal()
  {
    return $this->belongsTo(DataAwal::class, 'data_awal_id');
  }

  public function profilecompanybank()
  {
    return $this->belongsTo(ProfileCompanyBank::class,  'id_profile_company_banks');
  }
}
