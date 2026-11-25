<?php

namespace App\Filament\Resources;

use App\Models\Realisation;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;
use Filament\Resources\Resource;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class RealisationResource extends Resource
{
    protected static ?string $model = Realisation::class;

    public static function form(Schema $schema): Schema
    {
        return $schema->schema([TextInput::make('titre')->required(), TextInput::make('slug')->required()->unique(ignoreRecord: true), TextInput::make('secteur')->required(), Textarea::make('problematique'), Textarea::make('solution'), Textarea::make('resultat'), FileUpload::make('images')->disk('wasabi')->directory('realisations')->multiple(), TextInput::make('video_url')->url()]);
    }

    public static function table(Table $table): Table
    {
        return $table->columns([TextColumn::make('titre')->searchable(), TextColumn::make('secteur'), TextColumn::make('created_at')->date()]);
    }
    public static function getPages(): array
    {
        return [
            'index' => \App\Filament\Resources\RealisationResource\Pages\ListRealisations::route('/'),
            'create' => \App\Filament\Resources\RealisationResource\Pages\CreateRealisation::route('/create'),
            'edit' => \App\Filament\Resources\RealisationResource\Pages\EditRealisation::route('/{record}/edit'),
        ];
    }
}
