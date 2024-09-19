<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;

    // Jika tabel yang digunakan berbeda dengan nama model
    protected $table = 'invoices';

    // Kolom yang bisa diisi
    protected $fillable = [
        'kode_invoice',
        'user_id',
        'total_tagihan',
        'status'
    ];

    // Relasi dengan model User (contoh)
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
