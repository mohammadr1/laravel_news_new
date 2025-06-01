<?php

namespace App\Filament\Resources\DailyMediaResource\Pages;

use App\Filament\Resources\DailyMediaResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditDailyMedia extends EditRecord
{
    protected static string $resource = DailyMediaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
