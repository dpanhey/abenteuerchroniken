<?php

namespace App\Filament\Resources\AdventureResource\Pages;

use App\Filament\Resources\AdventureResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateAdventure extends CreateRecord
{
    protected static string $resource = AdventureResource::class;
    protected static bool $canCreateAnother = false;
    protected static ?string $title = 'Abenteuer erstellen';

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['user_id'] = auth()->id();

        return $data;
    }
}
