<?php

namespace App\Models;

use App\Traits\Uuid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class UserMenuAuthorization extends Model
{
  use HasFactory, Uuid;

  protected $primaryKey = 'id_user_menu_authorizations';
  public $incrementing = false;
  protected $table = 'user_menu_authorizations';

  protected $fillable = [
    'roles_id',
    'menus_id',
    'action_user_menu_authorizations',
    'publish_user_menu_authorizations'
  ];

  public function menu(): HasOne
  {
    return $this->hasOne(Menu::class, 'id_menus', 'menus_id');
  }
}