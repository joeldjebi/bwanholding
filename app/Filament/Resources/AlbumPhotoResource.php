<?php

namespace App\Filament\Resources;

use App\Models\Album;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;
use Filament\Resources\Resource;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class AlbumPhotoResource extends Resource
{
    protected static ?string $model = Album::class;
    protected static ?string $navigationLabel = 'Albums photo';

    public static function form(Schema $schema): Schema
    {
        return $schema->schema([TextInput::make('titre')->required(), TextInput::make('categorie'), DatePicker::make('date')]);
    }

    public static function table(Table $table): Table
    {
        return $table->columns([TextColumn::make('titre')->searchable(), TextColumn::make('categorie'), TextColumn::make('date')->date()]);
    }
    public static function getPages(): array
    {
        return [
            'index' => \App\Filament\Resources\AlbumPhotoResource\Pages\ListAlbumPhotos::route('/'),
            'create' => \App\Filament\Resources\AlbumPhotoResource\Pages\CreateAlbumPhoto::route('/create'),
            'edit' => \App\Filament\Resources\AlbumPhotoResource\Pages\EditAlbumPhoto::route('/{record}/edit'),
        ];
    }
}
