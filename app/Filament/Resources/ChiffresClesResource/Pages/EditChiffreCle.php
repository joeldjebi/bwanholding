<?php

namespace App\Filament\Resources\ChiffresClesResource\Pages;

use App\Filament\Resources\ChiffresClesResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditChiffreCle extends EditRecord
{
    protected static string $resource = ChiffresClesResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
