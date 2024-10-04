<?php

namespace App\Filament\Resources\ContentUpdateResource\Pages;

use App\Filament\Resources\ContentUpdateResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListContentUpdates extends ListRecords
{
    protected static string $resource = ContentUpdateResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
