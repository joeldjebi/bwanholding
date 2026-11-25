<?php

namespace App\Filament\Resources;

use App\Models\Domaine;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;
use Filament\Resources\Resource;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class DomaineResource extends Resource
{
    protected static ?string $model = Domaine::class;

    public static function form(Schema $schema): Schema
    {
        return $schema->schema([TextInput::make('nom')->required(), TextInput::make('slug')->required()->unique(ignoreRecord: true), TextInput::make('icone'), Textarea::make('description')->columnSpanFull(), TextInput::make('ordre')->numeric()->default(0)]);
    }

    public static function table(Table $table): Table
    {
        return $table->columns([TextColumn::make('nom')->searchable(), TextColumn::make('slug'), TextColumn::make('ordre')->sortable()]);
    }
    public static function getPages(): array
    {
        return [
            'index' => \App\Filament\Resources\DomaineResource\Pages\ListDomaines::route('/'),
            'create' => \App\Filament\Resources\DomaineResource\Pages\CreateDomaine::route('/create'),
            'edit' => \App\Filament\Resources\DomaineResource\Pages\EditDomaine::route('/{record}/edit'),
        ];
    }
}
