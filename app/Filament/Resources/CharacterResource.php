<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CharacterResource\Pages;
use App\Filament\Resources\CharacterResource\RelationManagers;
use App\Models\Character;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Infolists\Components\SpatieMediaLibraryImageEntry;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\SpatieMediaLibraryImageColumn;
use Filament\Tables\Table;
use Filament\Infolists;
use Filament\Infolists\Infolist;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class CharacterResource extends Resource
{
    protected static ?string $model = Character::class;
    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationLabel = 'Charaktere';
    protected static ?string $slug = 'charaktere';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Tabs::make('Tabs')
                    ->tabs([
                        Forms\Components\Tabs\Tab::make('Persönliche Daten')
                            ->schema([
                                Forms\Components\Fieldset::make('Persönliche Daten')
                                    ->schema([
                                        Forms\Components\TextInput::make('name')
                                            ->required()
                                            ->maxLength(255),
                                        Forms\Components\TextInput::make('familie')
                                            ->maxLength(255),
                                        Forms\Components\TextInput::make('geburtsort')
                                            ->maxLength(255),
                                        Forms\Components\TextInput::make('geburtsdatum')
                                            ->maxLength(255),
                                        Forms\Components\TextInput::make('alter')
                                            ->maxLength(255),
                                        Forms\Components\TextInput::make('geschlecht')
                                            ->maxLength(255),
                                        Forms\Components\TextInput::make('groesse')
                                            ->numeric(),
                                        Forms\Components\TextInput::make('gewicht')
                                            ->numeric(),
                                        Forms\Components\TextInput::make('haarfarbe')
                                            ->maxLength(255),
                                        Forms\Components\TextInput::make('augenfarbe')
                                            ->maxLength(255),
                                        Forms\Components\TextInput::make('titel')
                                            ->maxLength(255),
                                        Forms\Components\TextInput::make('sozialstatus')
                                            ->maxLength(255),
                                        Forms\Components\Textarea::make('charakteristiken')
                                            ->maxLength(65535)
                                            ->columns(2),
                                        Forms\Components\Textarea::make('hintergrundgeschichte')
                                            ->maxLength(65535)
                                            ->columns(2),
                                        Forms\Components\Textarea::make('andere_informationen')
                                            ->maxLength(65535)
                                            ->columns(2),
                                        Forms\Components\TextInput::make('ap_gesamt')
                                            ->numeric(),
                                        Forms\Components\TextInput::make('ap_verfuegbar')
                                            ->numeric(),
                                        Forms\Components\TextInput::make('ap_ausgegeben')
                                            ->numeric(),
                                        Forms\Components\SpatieMediaLibraryFileUpload::make('portrait_url')
                                            ->label('Portrait')
                                            ->avatar()
                                            ->imageEditor()
                                            ->circleCropper(),
                                        Forms\Components\Toggle::make('lebendig')
                                            ->required(),
                                    ])
                                    ->columns(5),
                            ]),
                        Forms\Components\Tabs\Tab::make('Charakterwerte')
                            ->schema([
                                Forms\Components\Group::make()
                                    ->relationship('attributes')
                                    ->schema([
                                        Forms\Components\Fieldset::make('Attribute')
                                            ->schema([
                                                Forms\Components\TextInput::make('mut')
                                                    ->label('Mut')
                                                    ->numeric()
                                                    ->default(8),
                                                Forms\Components\TextInput::make('klugheit')
                                                    ->label('Klugheit')
                                                    ->numeric()
                                                    ->default(8),
                                                Forms\Components\TextInput::make('intuition')
                                                    ->label('Intuition')
                                                    ->numeric()
                                                    ->default(8),
                                                Forms\Components\TextInput::make('charisma')
                                                    ->label('Charisma')
                                                    ->numeric()
                                                    ->default(8),
                                                Forms\Components\TextInput::make('fingerfertigkeit')
                                                    ->label('Fingerfertigkeit')
                                                    ->numeric()
                                                    ->default(8),
                                                Forms\Components\TextInput::make('gewandtheit')
                                                    ->label('Gewandtheit')
                                                    ->numeric()
                                                    ->default(8),
                                                Forms\Components\TextInput::make('konstitution')
                                                    ->label('Konstitution')
                                                    ->numeric()
                                                    ->default(8),
                                                Forms\Components\TextInput::make('koerperkraft')
                                                    ->label('Körperkraft')
                                                    ->numeric()
                                                    ->default(8),
                                            ])
                                            ->columns(8),
                                        Forms\Components\Fieldset::make('Basis Werte')
                                            ->schema([
                                                Forms\Components\TextInput::make('lebensenergie')
                                                    ->numeric()
                                                    ->default(21),
                                                Forms\Components\TextInput::make('astralenergie')
                                                    ->numeric()
                                                    ->default(0),
                                                Forms\Components\TextInput::make('karmaenergie')
                                                    ->numeric()
                                                    ->default(0),
                                                Forms\Components\TextInput::make('seelenkraft')
                                                    ->numeric()
                                                    ->default(-1),
                                                Forms\Components\TextInput::make('zaehigkeit')
                                                    ->numeric()
                                                    ->label('Zähigkeit')
                                                    ->default(-1),
                                                Forms\Components\TextInput::make('ausweichen')
                                                    ->numeric()
                                                    ->default(4),
                                                Forms\Components\TextInput::make('initiative')
                                                    ->numeric()
                                                    ->default(8),
                                                Forms\Components\TextInput::make('wundschwelle')
                                                    ->numeric()
                                                    ->default(4),
                                                Forms\Components\TextInput::make('geschwindigkeit')
                                                    ->numeric()
                                                    ->default(8),
                                                Forms\Components\TextInput::make('schicksalspunkte')
                                                    ->numeric()
                                                    ->default(3),
                                            ])
                                            ->columns(5),
                                    ])
                                    ->columnSpanFull(),
                            ]),
                        Forms\Components\Tabs\Tab::make('Spielwerte')
                            ->schema([]),
                        Forms\Components\Tabs\Tab::make('Kampf')
                            ->schema([]),
                        Forms\Components\Tabs\Tab::make('Besitz & Begleiter')
                            ->schema([]),
                        Forms\Components\Tabs\Tab::make('Zauber & Rituale')
                            ->schema([]),
                        Forms\Components\Tabs\Tab::make('Liturgien & Zeremonien')
                            ->schema([]),
                    ])
                    ->columnSpanFull()
                    ->contained(false)
            ]);
    }

    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                Infolists\Components\Tabs::make('Tabs')
                    ->tabs([
                        Infolists\Components\Tabs\Tab::make('Persönliche Daten')
                            ->schema([
                                Infolists\Components\Group::make()
                                    ->relationship('attributes')
                                    ->columnSpanFull()
                                    ->schema([
                                        Infolists\Components\Fieldset::make('Attribute')
                                            ->schema([
                                                Infolists\Components\TextEntry::make('mut')
                                                    ->label('MU'),
                                                Infolists\Components\TextEntry::make('klugheit')
                                                    ->label('KL'),
                                                Infolists\Components\TextEntry::make('intuition')
                                                    ->label('IN'),
                                                Infolists\Components\TextEntry::make('charisma')
                                                    ->label('CH'),
                                                Infolists\Components\TextEntry::make('fingerfertigkeit')
                                                    ->label('FF'),
                                                Infolists\Components\TextEntry::make('gewandtheit')
                                                    ->label('GE'),
                                                Infolists\Components\TextEntry::make('konstitution')
                                                    ->label('KO'),
                                                Infolists\Components\TextEntry::make('koerperkraft')
                                                    ->label('KK'),
                                            ])
                                            ->columns(8)
                                    ]),
                                Infolists\Components\Group::make()
                                    ->columnSpan(3)
                                    ->schema([
                                        Infolists\Components\Fieldset::make('Persönliche Daten')
                                            ->schema([
                                                SpatieMediaLibraryImageEntry::make('portrait_url')
                                                    ->label('Charakterporträt'),
                                                Infolists\Components\IconEntry::make('lebendig')
                                                    ->label('Lebendig')
                                                    ->boolean(),
                                                Infolists\Components\TextEntry::make('name'),
                                                Infolists\Components\TextEntry::make('familie'),
                                                Infolists\Components\TextEntry::make('geburtsort'),
                                                Infolists\Components\TextEntry::make('geburtsdatum'),
                                                Infolists\Components\TextEntry::make('alter')
                                                    ->suffix(' Götterläufe'),
                                                Infolists\Components\TextEntry::make('geschlecht'),
                                                Infolists\Components\TextEntry::make('groesse')
                                                    ->label('Größe')
                                                    ->suffix(' Finger')
                                                    ->numeric(),
                                                Infolists\Components\TextEntry::make('gewicht')
                                                    ->suffix(' Stein')
                                                    ->numeric(),
                                                Infolists\Components\TextEntry::make('haarfarbe'),
                                                Infolists\Components\TextEntry::make('augenfarbe'),
                                                Infolists\Components\TextEntry::make('titel'),
                                                Infolists\Components\TextEntry::make('sozialstatus'),
                                                Infolists\Components\TextEntry::make('ap_gesamt')
                                                    ->label('AP gesamt')
                                                    ->numeric(),
                                                Infolists\Components\TextEntry::make('ap_verfuegbar')
                                                    ->label('AP verfügbar')
                                                    ->numeric(),
                                                Infolists\Components\TextEntry::make('ap_ausgegeben')
                                                    ->label('AP ausgegeben')
                                                    ->numeric(),
                                                Infolists\Components\TextEntry::make('charakteristiken')
                                                    ->columnSpan(2),
                                                Infolists\Components\TextEntry::make('hintergrundgeschichte')
                                                    ->columnSpan(2),
                                                Infolists\Components\TextEntry::make('andere_informationen')
                                                    ->columnSpan(2),
                                            ])
                                            ->columns(3),
                                    ]),
                                Infolists\Components\Group::make()
                                    ->relationship('attributes')
                                    ->columnSpan(1)
                                    ->schema([
                                        Infolists\Components\Fieldset::make('Basis Werte')
                                            ->schema([
                                                Infolists\Components\TextEntry::make('lebensenergie'),
                                                Infolists\Components\TextEntry::make('astralenergie'),
                                                Infolists\Components\TextEntry::make('karmaenergie'),
                                                Infolists\Components\TextEntry::make('seelenkraft'),
                                                Infolists\Components\TextEntry::make('zaehigkeit')
                                                ->label('Zähigkeit'),
                                                Infolists\Components\TextEntry::make('ausweichen'),
                                                Infolists\Components\TextEntry::make('initiative'),
                                                Infolists\Components\TextEntry::make('wundschwelle'),
                                                Infolists\Components\TextEntry::make('geschwindigkeit'),
                                                Infolists\Components\TextEntry::make('schicksalspunkte'),
                                            ])
                                        ->columns(1)
                                    ])

                            ])
                            ->columns(4),
                        Infolists\Components\Tabs\Tab::make('Spielwerte')
                            ->schema([]),
                        Infolists\Components\Tabs\Tab::make('Kampf')
                            ->schema([]),
                        Infolists\Components\Tabs\Tab::make('Besitz & Begleiter')
                            ->schema([]),
                        Infolists\Components\Tabs\Tab::make('Zauber & Rituale')
                            ->schema([]),
                        Infolists\Components\Tabs\Tab::make('Liturgien & Zeremonien')
                            ->schema([]),
                    ])
                    ->columnSpanFull()
                    ->contained(false)
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                SpatieMediaLibraryImageColumn::make('portrait_url')
                    ->label('Portrait')
                    ->circular(),
                Tables\Columns\TextColumn::make('name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('ap_gesamt')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\IconColumn::make('lebendig')
                    ->boolean(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                //
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCharacters::route('/'),
            'create' => Pages\CreateCharacter::route('/create'),
            'view' => Pages\ViewCharacter::route('/{record}'),
            'edit' => Pages\EditCharacter::route('/{record}/edit'),
        ];
    }
}
