<?php

namespace App\Filament\Resources\CommuniqueResource\Pages;

use App\Filament\Resources\CommuniqueResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditCommunique extends EditRecord
{
    protected static string $resource = CommuniqueResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
