<?php

namespace App\Filament\Resources;

use App\Models\Candidature;
use Filament\Forms\Components\Select;
use Filament\Schemas\Schema;
use Filament\Resources\Resource;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class CandidatureResource extends Resource
{
    protected static ?string $model = Candidature::class;

    public static function form(Schema $schema): Schema
    {
        return $schema->schema([Select::make('statut')->options(['nouvelle' => 'Nouvelle', 'en_cours' => 'En cours', 'retenue' => 'Retenue', 'refusee' => 'Refusée'])->required()]);
    }

    public static function table(Table $table): Table
    {
        return $table->columns([TextColumn::make('nom')->searchable(), TextColumn::make('email'), TextColumn::make('offre.titre'), TextColumn::make('statut'), TextColumn::make('created_at')->dateTime()]);
    }
    public static function getPages(): array
    {
        return [
            'index' => \App\Filament\Resources\CandidatureResource\Pages\ListCandidatures::route('/'),
            'edit' => \App\Filament\Resources\CandidatureResource\Pages\EditCandidature::route('/{record}/edit'),
        ];
    }
}
