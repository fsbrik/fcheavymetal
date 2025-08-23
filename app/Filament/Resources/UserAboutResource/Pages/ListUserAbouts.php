<?php

namespace App\Filament\Resources\UserAboutResource\Pages;

use App\Filament\Resources\UserAboutResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListUserAbouts extends ListRecords
{
    protected static string $resource = UserAboutResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
