<?php

namespace App\Filament\Resources\AdventureResource\Pages;

use App\Filament\Resources\AdventureResource;
use Filament\Actions;
use Filament\Resources\Components\Tab;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Database\Eloquent\Builder;

class ListAdventures extends ListRecords
{
    protected static string $resource = AdventureResource::class;
    protected static ?string $title = 'Abenteuer';

    public function getTabs(): array
    {
        return [
            'Meine Abenteuer' => Tab::make()
            ->modifyQueryUsing(fn (Builder $query) => $query->where('user_id', auth()->id())),
            'Alle Abenteuer' => Tab::make()
        ];
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
