<?php

namespace App\Filament\Resources\UserAboutResource\Pages;

use App\Filament\Resources\UserAboutResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditUserAbout extends EditRecord
{
    protected static string $resource = UserAboutResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
