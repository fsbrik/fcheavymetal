<?php

namespace App\Filament\Applicant\Resources\ApplicantResource\Pages;

use App\Filament\Applicant\Resources\ApplicantResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditApplicant extends EditRecord
{
    protected static string $resource = ApplicantResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
}
