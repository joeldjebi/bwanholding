<?php

namespace App\Filament\Resources;

use App\Models\Photo;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;
use Filament\Resources\Resource;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class PhotoResource extends Resource
{
    protected static ?string $model = Photo::class;

    public static function form(Schema $schema): Schema
    {
        return $schema->schema([Select::make('album_id')->relationship('album', 'titre')->required(), FileUpload::make('url')->disk('wasabi')->directory('albums')->required(), TextInput::make('legende')]);
    }

    public static function table(Table $table): Table
    {
        return $table->columns([TextColumn::make('album.titre'), TextColumn::make('legende')]);
    }
    public static function getPages(): array
    {
        return [
            'index' => \App\Filament\Resources\PhotoResource\Pages\ListPhotos::route('/'),
            'create' => \App\Filament\Resources\PhotoResource\Pages\CreatePhoto::route('/create'),
            'edit' => \App\Filament\Resources\PhotoResource\Pages\EditPhoto::route('/{record}/edit'),
        ];
    }
}
