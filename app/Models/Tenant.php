<?php

namespace App\Models;

use App\Models\Traits\HasUuid;
use Database\Factories\TenantFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Tenant extends Model
{
    use HasUuid;
    use HasFactory;

    protected $guarded = [];

    protected static function newFactory(): TenantFactory
    {
        return TenantFactory::new();
    }

    public function owner(): HasOne
    {
        return $this->hasOne(User::class, 'id', 'owner_id');
    }
}
