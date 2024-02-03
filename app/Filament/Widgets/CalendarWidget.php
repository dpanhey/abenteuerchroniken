<?php

namespace App\Filament\Widgets;

use App\Models\Availability;
use App\Models\User;
use Filament\Actions\Action;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Group;
use Saade\FilamentFullCalendar\Data\EventData;
use Saade\FilamentFullCalendar\Widgets\FullCalendarWidget;
use Saade\FilamentFullCalendar\Actions;
use Filament\Forms\Form;
use Illuminate\Database\Eloquent\Model;

class CalendarWidget extends FullCalendarWidget
{
    public Model|string|null $model = Availability::class;

    public function fetchEvents(array $fetchInfo): array
    {
        return Availability::query()
            ->get()
            ->map(
                function (Availability $availability) {
                    $user = User::find($availability->user_id);

                    return EventData::make()
                        ->id($availability->id)
                        ->title($user->name)
                        ->start($availability->starts_at)
                        ->end($availability->ends_at);
                }
            )
            ->toArray();
    }

    protected function modalActions(): array
    {
        return [
            Actions\EditAction::make()
                ->hidden(fn ($record) => $record->user_id !== auth()->id())
                ->mountUsing(
                    function (Availability $record, Form $form, array $arguments) {
                        $form->fill([
                            'name' => $record->name,
                            'starts_at' => $arguments['event']['start'] ?? $record->starts_at,
                            'ends_at' => $arguments['event']['end'] ?? $record->ends_at
                        ]);
                    }
                ),
            Actions\DeleteAction::make()
                ->hidden(fn($record) => $record->user_id !== auth()->id())
        ];
    }

    protected function viewAction(): Action
    {
        return Actions\ViewAction::make();
    }

    public function getFormSchema(): array
    {
        return [
            Grid::make(2)
            ->schema([
                DateTimePicker::make('starts_at')
                    ->label('Verfügbar ab')
                    ->required()
                    ->displayFormat('l, d F H:i:s')
                    ->native(false)
                    ->seconds(false),
                DateTimePicker::make('ends_at')
                    ->label('Verfügbar bis')
                    ->required()
                    ->displayFormat('l, d F H:i:s')
                    ->native(false)
                    ->seconds(false),
            ])
        ];
    }

    protected function headerActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->createAnother(false)
                ->mountUsing(
                    function (Form $form, array $arguments) {
                        $form->fill([
                            'starts_at' => $arguments['start'] ?? null,
                            'ends_at' => $arguments['end'] ?? null
                        ]);
                    }
                )
                ->mutateFormDataUsing(
                    function (array $data): array {
                        $data['user_id'] = auth()->id();

                        return $data;
                    }
                )
            ->modalHeading('Verfügbarkeit eintragen.')
            ->modalSubmitActionLabel('Eintragen')
        ];
    }
}
