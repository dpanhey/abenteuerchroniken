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
                            ->columnSpanFull(),
                        Forms\Components\Textarea::make('hintergrundgeschichte')
                            ->maxLength(65535)
                            ->columnSpanFull(),
                        Forms\Components\Textarea::make('andere_informationen')
                            ->maxLength(65535)
                            ->columnSpanFull(),
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
                    ->columns(4)
            ]);
    }

    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                Infolists\Components\Fieldset::make('Persönliche Daten')
                    ->schema([
                        SpatieMediaLibraryImageEntry::make('portrait_url')
                        ->label('Charakterportrait')
                        ->columnSpanFull(),
                        Infolists\Components\TextEntry::make('name'),
                        Infolists\Components\TextEntry::make('familie'),
                        Infolists\Components\TextEntry::make('geburtsort'),
                        Infolists\Components\TextEntry::make('geburtsdatum'),
                        Infolists\Components\TextEntry::make('alter'),
                        Infolists\Components\TextEntry::make('geschlecht'),
                        Infolists\Components\TextEntry::make('groesse')
                            ->label('Größe')
                            ->numeric(),
                        Infolists\Components\TextEntry::make('gewicht')
                            ->numeric(),
                        Infolists\Components\TextEntry::make('haarfarbe'),
                        Infolists\Components\TextEntry::make('augenfarbe'),
                        Infolists\Components\TextEntry::make('titel'),
                        Infolists\Components\TextEntry::make('sozialstatus'),
                        Infolists\Components\TextEntry::make('charakteristiken')
                            ->columnSpan(2),
                        Infolists\Components\TextEntry::make('hintergrundgeschichte')
                            ->columnSpan(2),
                        Infolists\Components\TextEntry::make('andere_informationen')
                            ->columnSpan(2),
                        Infolists\Components\TextEntry::make('ap_gesamt')
                            ->label('Gesamte AP')
                            ->numeric(),
                        Infolists\Components\TextEntry::make('ap_verfuegbar')
                            ->label('Verfügbare AP')
                            ->numeric(),
                        Infolists\Components\TextEntry::make('ap_ausgegeben')
                            ->label('Ausgegebene AP')
                            ->numeric(),
                        Infolists\Components\IconEntry::make('lebendig')
                            ->label('Lebendig')
                            ->boolean(),
                    ])
                ->columns(4)
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
