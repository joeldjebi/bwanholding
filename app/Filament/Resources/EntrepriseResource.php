<?php

namespace App\Filament\Resources;

use App\Models\Entreprise;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;
use Filament\Resources\Resource;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class EntrepriseResource extends Resource
{
    protected static ?string $model = Entreprise::class;

    public static function form(Schema $schema): Schema
    {
        return $schema->schema([
            TextInput::make('nom')->required(), TextInput::make('slug')->required()->unique(ignoreRecord: true),
            FileUpload::make('logo')->disk('wasabi')->directory('entreprises'),
            Select::make('domaine_id')->relationship('domaine', 'nom')->required(),
            Textarea::make('description')->columnSpanFull(),
            Repeater::make('services')->simple(TextInput::make('service'))->columnSpanFull(),
            TextInput::make('cible'), Select::make('statut')->options(['active' => 'Active', 'incubation' => 'Incubation', 'pause' => 'Pause'])->default('active'),
            TextInput::make('ordre')->numeric()->default(0),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table->columns([TextColumn::make('nom')->searchable(), TextColumn::make('domaine.nom'), TextColumn::make('statut'), TextColumn::make('ordre')->sortable()]);
    }
    public static function getPages(): array
    {
        return [
            'index' => \App\Filament\Resources\EntrepriseResource\Pages\ListEntreprises::route('/'),
            'create' => \App\Filament\Resources\EntrepriseResource\Pages\CreateEntreprise::route('/create'),
            'edit' => \App\Filament\Resources\EntrepriseResource\Pages\EditEntreprise::route('/{record}/edit'),
        ];
    }
}
