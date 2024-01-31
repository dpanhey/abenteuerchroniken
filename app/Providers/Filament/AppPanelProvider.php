<?php

namespace App\Providers\Filament;

use App\Filament\Pages\Auth\EditProfile;
use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Navigation\MenuItem;
use Filament\Pages;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Filament\Widgets;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\AuthenticateSession;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;
use Saade\FilamentFullCalendar\FilamentFullCalendarPlugin;

class AppPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()
            ->id('app')
            ->path('app')
            ->plugin(
                FilamentFullCalendarPlugin::make()
                    ->selectable(true)
                    ->editable(true)
                    ->plugins(['dayGrid', 'timeGrid', 'interaction', 'list'])
                    ->locale('de')
                    ->config([
                        'headerToolbar' => [
                            'left' => 'prev,next today',
                            'center' => 'title',
                            'right' => 'timeGridWeek,dayGridMonth,listMonth',
                        ],
                        'initialView' => 'timeGridWeek',
//                        'hiddenDays' => [1, 2, 3, 4, 5],
                        'dayHeaderFormat' => [
                            'weekday' => 'long',
                        ],
                        'contentHeight' => 'auto',
                        'showNonCurrentDates' => false,
                        'height' => 'auto',
                        'eventDisplay' => 'auto',
                        'displayEventEnd' => true,
                        'slotMinTime' => '12:00:00',
                        'eventOverlap' => false
                    ])
            )
            ->profile(EditProfile::class)
            ->userMenuItems([
                'profile' => MenuItem::make(),
//                    ->url('/user/profile'),
                'logout' => MenuItem::make()
            ])
            ->topNavigation()
            ->spa()
            ->font('Merriweather')
            ->colors([
                'primary' => Color::Sky,
                'gray' => Color::Blue,
            ])
            ->darkMode(false)
            ->viteTheme('resources/css/filament/app/theme.css')
            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\\Filament\\Resources')
            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\\Filament\\Pages')
            ->pages([])
            ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\\Filament\\Widgets')
            ->widgets([
//                Widgets\AccountWidget::class,
//                Widgets\FilamentInfoWidget::class,
            ])
            ->middleware([
                EncryptCookies::class,
                AddQueuedCookiesToResponse::class,
                StartSession::class,
                AuthenticateSession::class,
                ShareErrorsFromSession::class,
                VerifyCsrfToken::class,
                SubstituteBindings::class,
                DisableBladeIconComponents::class,
                DispatchServingFilamentEvent::class,
            ])
            ->authMiddleware([
                Authenticate::class,
            ]);
    }
}
