<?php

namespace App\Filament\Resources;

use App\Models\Article;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;
use Filament\Resources\Resource;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class ArticleResource extends Resource
{
    protected static ?string $model = Article::class;

    public static function form(Schema $schema): Schema
    {
        return $schema->schema([TextInput::make('titre')->required(), TextInput::make('slug')->required()->unique(ignoreRecord: true), Select::make('categorie')->options(['actualite' => 'Actualité', 'communique' => 'Communiqué'])->default('actualite'), Select::make('statut')->options(['brouillon' => 'Brouillon', 'publie' => 'Publié'])->default('brouillon'), DatePicker::make('date_publication'), FileUpload::make('image')->disk('wasabi')->directory('articles'), RichEditor::make('contenu')->required()->columnSpanFull()]);
    }

    public static function table(Table $table): Table
    {
        return $table->columns([TextColumn::make('titre')->searchable(), TextColumn::make('categorie'), TextColumn::make('statut'), TextColumn::make('date_publication')->date()]);
    }
    public static function getPages(): array
    {
        return [
            'index' => \App\Filament\Resources\ArticleResource\Pages\ListArticles::route('/'),
            'create' => \App\Filament\Resources\ArticleResource\Pages\CreateArticle::route('/create'),
            'edit' => \App\Filament\Resources\ArticleResource\Pages\EditArticle::route('/{record}/edit'),
        ];
    }
}
