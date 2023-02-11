<?php

namespace App\Models;

use App\Traits\Uuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PriceSettings extends Model
{
  use HasFactory, SoftDeletes, Uuid;

  protected $primaryKey = 'id_price_settings';
  public $incrementing = false;

  protected $fillable = [
    'minimum_value_per_cubic_price_settings',
    'increase_in_price_per_cubic_price_settings',
    'type_ref_doc_price_settings',
    'ref_doc_price_settings',
    'is_active_price_settings',
  ];
}