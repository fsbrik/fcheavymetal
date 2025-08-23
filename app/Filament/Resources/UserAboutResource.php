<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserAboutResource\Pages;
use App\Filament\Resources\UserAboutResource\RelationManagers;
use App\Models\UserAbout;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Components\Select;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class UserAboutResource extends Resource
{
    protected static ?string $model = UserAbout::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('music_styles')
                    ->label('Music Styles')
                    ->options([
                        'heavy' => 'Heavy',
                        'thrash' => 'Thrash',
                        'death' => 'Death',
                        'black' => 'Black',
                        'viking' => 'Viking',
                        'power' => 'Power',
                        'gothic' => 'Gothic',
                        'doom' => 'Doom',
                        'grindcore' => 'Grindcore',
                        'metalcore' => 'Metalcore',
                        'deathcore' => 'Deathcore',
                        'glam' => 'Glam',
                        'hard_rock' => 'Hard Rock',
                        'progressive' => 'Progressive',
                    ])
                    ->multiple()
                    ->required(),
                Select::make('religion')
                    ->options([
                        'atheist' => 'Atheist/Agnostic',
                        'satanist' => 'Satanist',
                        'pagan' => 'Pagan',
                        'jewish' => 'Jewish',
                        'islamic' => 'Islamic',
                        'christian' => 'Christian',
                        'other' => 'Other',
                    ])
                    ->label('Religion'),
                Select::make('investment_availability')
                    ->options([
                        '<5000' => 'Less than $5,000',
                        '5001-10000' => '$5,001 - $10,000',
                        '10001-25000' => '$10,001 - $25,000',
                        '25001-50000' => '$25,001 - $50,000',
                        '50001-100000' => '$50,001 - $100,000',
                        '>100000' => 'More than $100,000',
                    ])
                    ->label('Investment Availability'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('user.name')->label('User'),
                TextColumn::make('music_styles')->label('Music Styles')->wrap(),
                TextColumn::make('religion')->label('Religion'),
                TextColumn::make('investment_availability')->label('Investment Availability'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
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
            'index' => Pages\ListUserAbouts::route('/'),
            'create' => Pages\CreateUserAbout::route('/create'),
            'edit' => Pages\EditUserAbout::route('/{record}/edit'),
        ];
    }
}
