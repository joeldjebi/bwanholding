<?php

namespace App\Filament\Resources\ChiffresClesResource\Pages;

use App\Filament\Resources\ChiffresClesResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListChiffresCles extends ListRecords
{
    protected static string $resource = ChiffresClesResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
