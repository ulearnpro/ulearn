<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RoleUser extends Model
{
    protected $table = 'role_user';
    public $timestamps = false;
    protected $guarded = array();

    public function user()
	{
		return $this->belongsT('App\Models\User', 'user_id', 'id');
	}
}
