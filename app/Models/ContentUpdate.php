<?php

namespace App\Models;

use App\Enums\UpdateStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ContentUpdate extends Model
{
    use HasFactory;

    protected $fillable = [
        'store_id',
        'path',
        'status',
        'update_installed_at'
    ];

    protected $casts = [
        'update_installed_at' => 'datetime',
        'status' => UpdateStatus::class,
    ];

    public function store(): BelongsTo
    {
        return $this->belongsTo(Store::class);
    }
}
