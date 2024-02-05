<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AdventureResource\Pages;
use App\Filament\Resources\AdventureResource\RelationManagers;
use App\Models\Adventure;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class AdventureResource extends Resource
{
    protected static ?string $model = Adventure::class;
    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationLabel = 'Abenteuer';
    protected static ?string $slug = 'abenteuer';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->label('Titel')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('kurzbeschreibung')
                    ->label('Kurzbeschreibung')
                    ->maxLength(255),
                Forms\Components\Select::make('abenteuertyp')
                    ->options([
                        'abenteuer' => 'Abenteuer',
                        'kampagne' => 'Kampagne',
                        'kurzabenteuer' => 'Kurzabenteuer',
                        'szenario' => 'Szenario',
                        'soloabenteuer' => 'Soloabenteuer',
                    ])
                    ->native(false),
                Forms\Components\RichEditor::make('beschreibung')
                    ->maxLength(65535)
                    ->columnSpanFull(),
                Forms\Components\Repeater::make('characters')
                    ->label('Charaktere')
                    ->schema([
                    ]),
            ])
            ->columns(3);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Titel')
                    ->description(fn(Adventure $record): string => $record->kurzbeschreibung),
                Tables\Columns\TextColumn::make('abenteuertyp')
                    ->formatStateUsing(fn(string $state): string => ucfirst($state)),
                Tables\Columns\TextColumn::make('user.name')
                    ->label('Meister'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
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
            'index' => Pages\ListAdventures::route('/'),
            'create' => Pages\CreateAdventure::route('/create'),
            'edit' => Pages\EditAdventure::route('/{record}/edit'),
        ];
    }
}
