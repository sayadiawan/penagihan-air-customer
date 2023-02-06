<?php

namespace App\Models;

use App\Traits\Uuid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Menu extends Model
{
  use HasFactory, SoftDeletes, Uuid;

  protected $primaryKey = 'id_menus';
  public $incrementing = false;

  protected $fillable = [
    'name_roles',
    'code_menus',
    'name_menus',
    'link_menus',
    'description_menus',
    'icon_menus',
    'action_menus'
  ];

  public function menu(): HasOne
  {
    return $this->hasOne(Menu::class, 'id_menus', 'upid_menus');
  }

  public function menus(): HasMany
  {
    return $this->hasMany(Menu::class, 'upid_menus', 'id_menus');
  }

  public function usermenunauthorization(): HasOne
  {
    return $this->hasOne(Role::class, 'menus_id', 'id_menus');
  }
}