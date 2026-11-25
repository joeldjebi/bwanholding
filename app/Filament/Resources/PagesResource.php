<?php

namespace App\Filament\Resources;

use App\Models\Page;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;
use Filament\Resources\Resource;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class PagesResource extends Resource
{
    protected static ?string $model = Page::class;
    protected static ?string $navigationLabel = 'Pages';

    public static function form(Schema $schema): Schema
    {
        return $schema->schema([
            TextInput::make('titre')->required()->maxLength(190),
            TextInput::make('slug')->required()->unique(ignoreRecord: true)->maxLength(190),
            RichEditor::make('contenu')->columnSpanFull(),
            TextInput::make('meta_title')->maxLength(190),
            Textarea::make('meta_description')->rows(3),
            FileUpload::make('og_image')->disk('wasabi')->directory('pages'),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table->columns([TextColumn::make('titre')->searchable(), TextColumn::make('slug'), TextColumn::make('updated_at')->dateTime()]);
    }
    public static function getPages(): array
    {
        return [
            'index' => \App\Filament\Resources\PagesResource\Pages\ListPages::route('/'),
            'create' => \App\Filament\Resources\PagesResource\Pages\CreatePage::route('/create'),
            'edit' => \App\Filament\Resources\PagesResource\Pages\EditPage::route('/{record}/edit'),
        ];
    }
}
