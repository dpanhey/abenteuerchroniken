<?php

namespace App\Filament\Pages;

use Filament\Pages\Dashboard as BaseDashboard;

class Dashboard extends BaseDashboard
{
    protected static string $routePath = 'Kalender';
    protected static ?string $title = 'Kalender';

    protected int | string | array $columnSpan = [
        'md' => 2,
        'lg' => 3,
        'xl' => 4,
    ];
}
