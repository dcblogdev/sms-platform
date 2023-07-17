<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TenantUser extends Model
{
    public $timestamps = false;
    protected $fillable = [
        'tenant_id',
        'user_id'
    ];
}
