<?php

namespace App\Models;

use App\Enums\LicenseStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use OwenIt\Auditing\Contracts\Auditable;

class License extends Model implements Auditable
{
    use HasFactory;
    use \OwenIt\Auditing\Auditable;

    protected $fillable = [
        'store_id',
        'license_key',
        'status',
        'expires_at'
    ];

    protected $casts = [
        'expires_at' => 'datetime',
        'status' => LicenseStatus::class
    ];

    public function store(): BelongsTo
    {
        return $this->belongsTo(Store::class);
    }
}
