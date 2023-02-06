<?php

namespace App\Models;

use App\Traits\Uuid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Role extends Model
{
  use HasFactory, SoftDeletes, Uuid;

  protected $primaryKey = 'id_roles';
  public $incrementing = false;

  protected $fillable = [
    'code_roles',
    'name_roles'
  ];

  public function user()
  {
    return $this->hasMany(User::class, 'id_roles', 'roles_id');
  }
}