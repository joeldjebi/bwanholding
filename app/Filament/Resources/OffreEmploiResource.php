<?php

namespace App\Filament\Resources;

use App\Models\OffreEmploi;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;
use Filament\Resources\Resource;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class OffreEmploiResource extends Resource
{
    protected static ?string $model = OffreEmploi::class;

    public static function form(Schema $schema): Schema
    {
        return $schema->schema([TextInput::make('titre')->required(), TextInput::make('slug')->required()->unique(ignoreRecord: true), TextInput::make('entite'), TextInput::make('type_contrat')->required(), TextInput::make('localisation')->required(), Select::make('statut')->options(['ouverte' => 'Ouverte', 'fermee' => 'Fermée'])->default('ouverte'), DatePicker::make('date_publication'), RichEditor::make('description')->required()->columnSpanFull()]);
    }

    public static function table(Table $table): Table
    {
        return $table->columns([TextColumn::make('titre')->searchable(), TextColumn::make('type_contrat'), TextColumn::make('localisation'), TextColumn::make('statut')]);
    }
    public static function getPages(): array
    {
        return [
            'index' => \App\Filament\Resources\OffreEmploiResource\Pages\ListOffreEmplois::route('/'),
            'create' => \App\Filament\Resources\OffreEmploiResource\Pages\CreateOffreEmploi::route('/create'),
            'edit' => \App\Filament\Resources\OffreEmploiResource\Pages\EditOffreEmploi::route('/{record}/edit'),
        ];
    }
}
