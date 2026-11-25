<?php

namespace App\Filament\Resources;

use App\Models\Setting;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;
use Filament\Resources\Resource;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class SettingsResource extends Resource
{
    protected static ?string $model = Setting::class;
    protected static ?string $navigationLabel = 'Paramètres';

    public static function form(Schema $schema): Schema
    {
        return $schema->schema([TextInput::make('cle')->required()->unique(ignoreRecord: true), Textarea::make('valeur')->rows(4)]);
    }

    public static function table(Table $table): Table
    {
        return $table->columns([TextColumn::make('cle')->searchable(), TextColumn::make('valeur')->limit(60)]);
    }
    public static function getPages(): array
    {
        return [
            'index' => \App\Filament\Resources\SettingsResource\Pages\ListSettings::route('/'),
            'create' => \App\Filament\Resources\SettingsResource\Pages\CreateSetting::route('/create'),
            'edit' => \App\Filament\Resources\SettingsResource\Pages\EditSetting::route('/{record}/edit'),
        ];
    }
}
