<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentDetail extends Model
{
    use HasFactory;

    protected $table = 'payment_detail';

    protected $primaryKey = 'id_payments_detail';

    // Atribut yang dapat diisi
    protected $fillable = [
        'payments_id',
        'payments_detail_type',
        'tagihan_id',
        'bulan',
        'tahun',
        'total'
    ];

    // Relasi ke Payment
    public function payment()
    {
        return $this->belongsTo(Payment::class, 'payments_id', 'id');
    }

    // Relasi ke Tagihan
    public function tagihan()
    {
        return $this->belongsTo(Tagihan::class, 'tagihan_id', 'id_tagihan');
    }
}
