<?php

namespace App\Filament\Resources\ContentUpdateResource\Pages;

use App\Filament\Resources\ContentUpdateResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditContentUpdate extends EditRecord
{
    protected static string $resource = ContentUpdateResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
