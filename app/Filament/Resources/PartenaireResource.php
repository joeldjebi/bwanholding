<?php

namespace App\Filament\Resources;

use App\Models\Partenaire;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;
use Filament\Resources\Resource;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class PartenaireResource extends Resource
{
    protected static ?string $model = Partenaire::class;

    public static function form(Schema $schema): Schema
    {
        return $schema->schema([TextInput::make('nom')->required(), FileUpload::make('logo')->disk('wasabi')->directory('partenaires'), TextInput::make('categorie')->required(), TextInput::make('ordre')->numeric()->default(0)]);
    }

    public static function table(Table $table): Table
    {
        return $table->columns([TextColumn::make('nom')->searchable(), TextColumn::make('categorie'), TextColumn::make('ordre')->sortable()]);
    }
    public static function getPages(): array
    {
        return [
            'index' => \App\Filament\Resources\PartenaireResource\Pages\ListPartenaires::route('/'),
            'create' => \App\Filament\Resources\PartenaireResource\Pages\CreatePartenaire::route('/create'),
            'edit' => \App\Filament\Resources\PartenaireResource\Pages\EditPartenaire::route('/{record}/edit'),
        ];
    }
}
