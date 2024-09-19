<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str; //

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'tagihan_id',
        'user_id',
        'jenis_pembayaran',
        'total_pembayaran'
    ];

    // Relasi dengan Tagihan
    public function tagihan()
    {
        return $this->belongsTo(Tagihan::class);
    }

    // Relasi dengan User (customer)
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function profilecompanybank()
    {
        return $this->belongsTo(ProfileCompanyBank::class);
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->id)) {
                $model->id = (string) Str::uuid(); // Menggunakan UUID untuk id
            }
        });
    }
}
