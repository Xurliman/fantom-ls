<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use OwenIt\Auditing\Contracts\Auditable;

class Store extends Model implements Auditable
{
    use HasFactory;
    use \OwenIt\Auditing\Auditable;

    protected $fillable = [
        'store_id',
        'name',
        'description',
        'url'
    ];

    public function license(): HasOne
    {
        return $this->hasOne(License::class);
    }

    public function contentUpdates(): HasMany {
        return $this->hasMany(ContentUpdate::class);
    }
}
