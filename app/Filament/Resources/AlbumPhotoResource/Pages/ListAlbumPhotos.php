<?php

namespace App\Filament\Resources\AlbumPhotoResource\Pages;

use App\Filament\Resources\AlbumPhotoResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListAlbumPhotos extends ListRecords
{
    protected static string $resource = AlbumPhotoResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
