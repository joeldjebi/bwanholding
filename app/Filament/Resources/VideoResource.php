<?php

namespace App\Filament\Resources;

use App\Models\Video;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;
use Filament\Resources\Resource;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class VideoResource extends Resource
{
    protected static ?string $model = Video::class;

    public static function form(Schema $schema): Schema
    {
        return $schema->schema([TextInput::make('titre')->required(), Textarea::make('description'), TextInput::make('url_embed')->url()->required(), FileUpload::make('thumbnail')->disk('wasabi')->directory('videos'), DatePicker::make('date')]);
    }

    public static function table(Table $table): Table
    {
        return $table->columns([TextColumn::make('titre')->searchable(), TextColumn::make('date')->date()]);
    }
    public static function getPages(): array
    {
        return [
            'index' => \App\Filament\Resources\VideoResource\Pages\ListVideos::route('/'),
            'create' => \App\Filament\Resources\VideoResource\Pages\CreateVideo::route('/create'),
            'edit' => \App\Filament\Resources\VideoResource\Pages\EditVideo::route('/{record}/edit'),
        ];
    }
}
