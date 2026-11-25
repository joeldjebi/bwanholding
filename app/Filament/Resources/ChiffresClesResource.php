<?php

namespace App\Filament\Resources;

use App\Models\ChiffreCle;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;
use Filament\Resources\Resource;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class ChiffresClesResource extends Resource
{
    protected static ?string $model = ChiffreCle::class;
    protected static ?string $navigationLabel = 'Chiffres clés';

    public static function form(Schema $schema): Schema
    {
        return $schema->schema([TextInput::make('libelle')->required(), TextInput::make('valeur')->required(), TextInput::make('icone'), TextInput::make('ordre')->numeric()->default(0)]);
    }

    public static function table(Table $table): Table
    {
        return $table->columns([TextColumn::make('libelle')->searchable(), TextColumn::make('valeur'), TextColumn::make('ordre')->sortable()]);
    }
    public static function getPages(): array
    {
        return [
            'index' => \App\Filament\Resources\ChiffresClesResource\Pages\ListChiffresCles::route('/'),
            'create' => \App\Filament\Resources\ChiffresClesResource\Pages\CreateChiffreCle::route('/create'),
            'edit' => \App\Filament\Resources\ChiffresClesResource\Pages\EditChiffreCle::route('/{record}/edit'),
        ];
    }
}
