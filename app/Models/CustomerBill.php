<?php

namespace App\Models;

use App\Traits\Uuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CustomerBill extends Model
{
  use HasFactory, SoftDeletes, Uuid;

  protected $primaryKey = 'id_customer_bills';
  public $incrementing = false;
}
