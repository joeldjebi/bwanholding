<?php

namespace App\Filament\Resources;

use App\Models\ContactMessage;
use Filament\Forms\Components\Select;
use Filament\Schemas\Schema;
use Filament\Resources\Resource;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class ContactMessageResource extends Resource
{
    protected static ?string $model = ContactMessage::class;

    public static function form(Schema $schema): Schema
    {
        return $schema->schema([Select::make('statut')->options(['nouveau' => 'Nouveau', 'en_cours' => 'En cours', 'traite' => 'Traité'])->required()]);
    }

    public static function table(Table $table): Table
    {
        return $table->columns([TextColumn::make('nom')->searchable(), TextColumn::make('email'), TextColumn::make('type_demande'), TextColumn::make('sujet'), TextColumn::make('statut')]);
    }
    public static function getPages(): array
    {
        return [
            'index' => \App\Filament\Resources\ContactMessageResource\Pages\ListContactMessages::route('/'),
            'edit' => \App\Filament\Resources\ContactMessageResource\Pages\EditContactMessage::route('/{record}/edit'),
        ];
    }
}
