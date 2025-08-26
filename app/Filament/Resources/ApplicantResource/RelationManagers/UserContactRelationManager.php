<?php

namespace App\Filament\Resources\ApplicantResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Forms\Components;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use App\Models\Country;
use App\Models\State;
use App\Models\City;
use Illuminate\Database\Eloquent\Model;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class UserContactRelationManager extends RelationManager
{
    protected static string $relationship = 'userContact';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
               /*  TextInput::make('user_id')
                    ->required()
                    ->maxLength(255), */
                TextInput::make('phone')->label('Phone'),
                                TextInput::make('instagram')->label('Instagram'),
                                TextInput::make('tiktok')->label('TikTok'),
                                TextInput::make('x_handle')->label('X'),
                                Select::make('country_id')
                                    ->label('Country')
                                    ->options(fn() => Country::query()->orderBy('name')->pluck('name', 'id'))
                                    ->searchable()
                                    ->preload()
                                    ->live()
                                    ->required()
                                    ->afterStateUpdated(fn(Set $set) => [
                                        $set('state_id', null),
                                        $set('city_id', null),
                                    ]),

                                Select::make('state_id')
                                    ->label('State')
                                    ->options(
                                        fn(Get $get) =>
                                        $get('country_id')
                                            ? State::where('country_id', $get('country_id'))
                                            ->orderBy('name')
                                            ->pluck('name', 'id')
                                            : []
                                    )
                                    ->searchable()
                                    ->preload()
                                    ->live()
                                    ->nullable() // 👈 aceptar null
                                    ->required(
                                        fn(Get $get) =>
                                        $get('country_id')
                                            && State::where('country_id', $get('country_id'))->exists()
                                    )
                                    ->afterStateUpdated(fn(Set $set) => $set('city_id', null)),

                                Select::make('userContact.city_id')
                                    ->label('City')
                                    ->options(
                                        fn(Get $get) =>
                                        $get('state_id')
                                            ? City::where('state_id', $get('state_id'))
                                            ->orderBy('name')
                                            ->pluck('name', 'id')
                                            : []
                                    )
                                    ->searchable()
                                    ->preload()
                                    ->nullable() // 👈 aceptar null
                                    ->required(
                                        fn(Get $get) =>
                                        $get('state_id')
                                            && City::where('state_id', $get('state_id'))->exists()
                                    ),
                                ]);
           
    }

    public function table(Table $table): Table
    {
        return $table
            //->recordTitleAttribute('')
            ->heading('Contact info') 
            ->description('how to reach you...')
            ->columns([
                TextColumn::make('phone')->label('Phone'),
                TextColumn::make('instagram')->label('Instagram'),
                TextColumn::make('tiktok')->label('TikTok'),
                TextColumn::make('x_handle')->label('X'),
                TextColumn::make('country.name')->label('Country'),
                TextColumn::make('state.name')->label('State'),
                TextColumn::make('city.name')->label('City'),
                //TextColumn::make('created_at')->label('Created')->dateTime(),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
