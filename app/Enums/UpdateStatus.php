<?php

namespace App\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasIcon;
use Filament\Support\Contracts\HasLabel;

enum UpdateStatus: string implements HasLabel, HasColor, HasIcon
{
    case UPDATE_INSTALLED = 'update_installed';
    case PENDING_UPDATE = 'pending_update';

    public function getLabel(): ?string
    {
        return match ($this) {
            self::UPDATE_INSTALLED => 'Update Installed',
            self::PENDING_UPDATE => 'Pending Update',
        };
    }

    public function getColor(): string|array|null
    {
        return match ($this) {
            self::UPDATE_INSTALLED => 'success',
            self::PENDING_UPDATE => 'warning',
        };
    }

    public function getIcon(): ?string
    {
        return match ($this) {
            self::UPDATE_INSTALLED => 'heroicon-m-check',
            self::PENDING_UPDATE => 'heroicon-m-exclamation-circle',
        };
    }
}


