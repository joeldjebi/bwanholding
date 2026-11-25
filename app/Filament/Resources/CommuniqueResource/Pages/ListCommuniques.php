<?php

namespace App\Filament\Resources\CommuniqueResource\Pages;

use App\Filament\Resources\CommuniqueResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListCommuniques extends ListRecords
{
    protected static string $resource = CommuniqueResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
