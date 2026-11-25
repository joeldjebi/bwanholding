<?php

namespace App\Filament\Resources;

class CommuniqueResource extends ArticleResource
{
    protected static ?string $navigationLabel = 'Communiqués';
    public static function getPages(): array
    {
        return [
            'index' => \App\Filament\Resources\CommuniqueResource\Pages\ListCommuniques::route('/'),
            'create' => \App\Filament\Resources\CommuniqueResource\Pages\CreateCommunique::route('/create'),
            'edit' => \App\Filament\Resources\CommuniqueResource\Pages\EditCommunique::route('/{record}/edit'),
        ];
    }
}
