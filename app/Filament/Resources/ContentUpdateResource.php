<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ContentUpdateResource\Pages;
use App\Filament\Resources\ContentUpdateResource\RelationManagers;
use App\Models\ContentUpdate;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ContentUpdateResource extends Resource
{
    protected static ?string $model = ContentUpdate::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('store_id')
                    ->relationship('store', 'name')
                    ->required(),
                Forms\Components\FileUpload::make('path')
                    ->disk('public')
                    ->uploadingMessage('Uploading attachment...')
                    ->required(),
                Forms\Components\Select::make('status')
                    ->options([
                        'update_installed' => 'Update installed',
                        'pending_update' => 'Pending update',
                    ])
                    ->hiddenOn('create'),
                Forms\Components\DateTimePicker::make('update_installed_at')
                    ->hiddenOn('create'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('store_id')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('path')
                    ->searchable(),
                Tables\Columns\TextColumn::make('status'),
                Tables\Columns\TextColumn::make('update_installed_at')
                    ->dateTime()
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListContentUpdates::route('/'),
            'create' => Pages\CreateContentUpdate::route('/create'),
            'edit' => Pages\EditContentUpdate::route('/{record}/edit'),
        ];
    }
}
