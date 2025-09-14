<?php

namespace App\Filament\Applicant\Resources;

use App\Filament\Applicant\Resources\ApplicantResource\Pages;
use App\Filament\Applicant\Resources\ApplicantResource\RelationManagers;
use App\Models\User;
use Illuminate\Container\Attributes\Auth;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Components\Tabs;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Section;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ApplicantResource extends Resource
{
    protected static ?string $model = User::class;
    protected static ?string $navigationLabel = 'Applicants';
    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Personal info')
                    ->description('Your basic info for reaching you')
                    ->schema([
                        /* Tabs::make('Applicant')
                    ->tabs([
                        Tabs\Tab::make('Personal Info')
                            ->schema([ */
                        TextInput::make('name')->required()->label('Full Name'),
                        TextInput::make('email')->email()->required(),
                        TextInput::make('password')
                            ->password()
                            ->required(fn(string $operation): bool => $operation === 'create')
                            ->dehydrateStateUsing(fn($state) => filled($state) ? bcrypt($state) : null)
                            ->dehydrated(fn($state) => filled($state)) // solo guarda si está lleno
                            ->label('Password')
                            ->minLength(8),
                        Select::make('gender')
                            ->options([
                                'male' => 'Male',
                                'female' => 'Female',
                            ])
                            ->required(),
                        DatePicker::make('birth_date')->required(),
                    ])
                    ->columns(2),
            ]);

        /* Tabs\Tab::make('Contact')
                            ->schema([
                                TextInput::make('userContact.phone')->label('Phone'),
                                TextInput::make('userContact.instagram')->label('Instagram'),
                                TextInput::make('userContact.tiktok')->label('TikTok'),
                                TextInput::make('userContact.x_handle')->label('X'),
                                Select::make('userContact.country_id')
                                    ->label('Country')
                                    ->options(fn() => Country::query()->orderBy('name')->pluck('name', 'id'))
                                    ->searchable()
                                    ->preload()
                                    ->live()
                                    ->required()
                                    ->afterStateUpdated(fn(Set $set) => [
                                        $set('userContact.state_id', null),
                                        $set('userContact.city_id', null),
                                    ]),

                                Select::make('userContact.state_id')
                                    ->label('State')
                                    ->options(
                                        fn(Get $get) =>
                                        $get('userContact.country_id')
                                            ? State::where('country_id', $get('userContact.country_id'))
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
                                        $get('userContact.country_id')
                                            && State::where('country_id', $get('userContact.country_id'))->exists()
                                    )
                                    ->afterStateUpdated(fn(Set $set) => $set('userContact.city_id', null)),

                                Select::make('userContact.city_id')
                                    ->label('City')
                                    ->options(
                                        fn(Get $get) =>
                                        $get('userContact.state_id')
                                            ? City::where('state_id', $get('userContact.state_id'))
                                            ->orderBy('name')
                                            ->pluck('name', 'id')
                                            : []
                                    )
                                    ->searchable()
                                    ->preload()
                                    ->nullable() // 👈 aceptar null
                                    ->required(
                                        fn(Get $get) =>
                                        $get('userContact.state_id')
                                            && City::where('state_id', $get('userContact.state_id'))->exists()
                                    ),
                            ]),
                        Tabs\Tab::make('About') 
                            ->schema([
                                Select::make('userAbout.musical_styles')
                                    ->multiple()
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
                                    ]),
                                Select::make('userAbout.religion')
                                    ->options([
                                        'atheist' => 'Atheist/Agnostic',
                                        'satanist' => 'Satanist',
                                        'pagan' => 'Pagan',
                                        'jewish' => 'Jewish',
                                        'islamic' => 'Islamic',
                                        'christian' => 'Christian',
                                        'other' => 'Other',
                                    ]),
                                Select::make('userAbout.investment_availability')
                                    ->options([
                                        'less_5000' => 'Less than $5,000',
                                        '5001_10000' => '$5,001 - $10,000',
                                        '10001_25000' => '$10,001 - $25,000',
                                        '25001_50000' => '$25,001 - $50,000',
                                        '50001_100000' => '$50,001 - $100,000',
                                        'more_100000' => 'More than $100,000',
                                    ]),
                            ]),
                    ]),
            ]); */
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')->label('Full Name')->sortable(),
                Tables\Columns\TextColumn::make('email')->label('Email')->sortable(),
                Tables\Columns\TextColumn::make('gender')->label('Gender')->sortable(),
                Tables\Columns\TextColumn::make('birth_date')->label('Birth Date')->sortable(),
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
            RelationManagers\UserContactRelationManager::class,
            RelationManagers\userAboutRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListApplicants::route('/'),
            'create' => Pages\CreateApplicant::route('/create'),
            'view' => Pages\ViewApplicant::route('/{record}'),
            'edit' => Pages\EditApplicant::route('/{record}/edit'),
        ];
    }
}
