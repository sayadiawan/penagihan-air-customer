<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $table = 'payments';

    protected $primaryKey = 'id';

    protected $fillable = [
        'id',
        'tagihan_id',
        'user_id',
        'jenis_pembayaran',
        'total_pembayaran',
        'kode_tagihan'
    ];

    // Relasi dengan Tagihan
    public function tagihan()
    {
        return $this->belongsTo(Tagihan::class);
    }

    private function generateSequentialNumber()
    {
        // Mengambil nomor urut terakhir dari kode_tagihan
        $lastPayment = Payment::orderBy('id', 'desc')->first();

        // Jika tidak ada pembayaran, mulai dari 1
        if (!$lastPayment) {
            return 1;
        }

        // Mengambil bagian angka dari kode_tagihan dan menambahkannya
        $lastNumber = (int) filter_var($lastPayment->kode_tagihan, FILTER_SANITIZE_NUMBER_INT);

        return $lastNumber + 1;
    }
}
