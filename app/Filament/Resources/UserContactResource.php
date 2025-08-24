<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserContactResource\Pages;
use App\Filament\Resources\UserContactResource\RelationManagers;
use App\Models\UserContact;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class UserContactResource extends Resource
{
    protected static ?string $model = UserContact::class;
    protected static bool $shouldRegisterNavigation = false;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('phone')->label('Phone')->tel(),
                TextInput::make('instagram')->label('Instagram'),
                TextInput::make('tiktok')->label('TikTok'),
                TextInput::make('x_handle')->label('X'),
                Select::make('country_id')->relationship('country', 'name')->label('Country'),
                Select::make('state_id')->relationship('state', 'name')->label('State'),
                Select::make('city_id')->relationship('city', 'name')->label('City'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('user.name')->label('User'),
                TextColumn::make('phone')->label('Phone'),
                TextColumn::make('instagram')->label('Instagram'),
                TextColumn::make('tiktok')->label('TikTok'),
                TextColumn::make('x_handle')->label('X'),
                TextColumn::make('country.name')->label('Country'),
                TextColumn::make('state.name')->label('State'),
                TextColumn::make('city.name')->label('City'),
                TextColumn::make('created_at')->label('Created')->dateTime(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
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
            'index' => Pages\ListUserContacts::route('/'),
            'create' => Pages\CreateUserContact::route('/create'),
            'edit' => Pages\EditUserContact::route('/{record}/edit'),
        ];
    }
}
