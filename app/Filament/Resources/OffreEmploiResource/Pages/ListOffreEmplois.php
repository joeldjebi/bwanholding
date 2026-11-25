<?php

namespace App\Filament\Resources\OffreEmploiResource\Pages;

use App\Filament\Resources\OffreEmploiResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListOffreEmplois extends ListRecords
{
    protected static string $resource = OffreEmploiResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
