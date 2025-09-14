<?php

namespace App\Filament\Applicant\Resources\ApplicantResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Components\Select;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class UserAboutRelationManager extends RelationManager
{
    protected static string $relationship = 'userAbout';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('musical_styles')
                    ->label('Musical Styles')
                    ->options([
                        'Heavy' => 'Heavy',
                        'Thrash' => 'Thrash',
                        'Death' => 'Death',
                        'Black' => 'Black',
                        'Viking' => 'Viking',
                        'Power' => 'Power',
                        'Gothic' => 'Gothic',
                        'Doom' => 'Doom',
                        'Grindcore' => 'Grindcore',
                        'Metalcore' => 'Metalcore',
                        'Deathcore' => 'Deathcore',
                        'Glam' => 'Glam',
                        'Hard Rock' => 'Hard Rock',
                        'Progressive' => 'Progressive',
                    ])
                    ->multiple()
                    ->required(),
                Select::make('religion')
                    ->options([
                        'atheist/agnostic' => 'Atheist/Agnostic',
                        'satanist' => 'Satanist',
                        'pagan' => 'Pagan',
                        'jewish' => 'Jewish',
                        'islamic' => 'Islamic',
                        'christian' => 'Christian',
                        'other' => 'Other',
                    ])
                    ->label('Religion')
                    ->required(),
                Select::make('education_level')
                    ->label('Education Level')
                    ->options([
                        'none' => 'No formal education',
                        'primary' => 'Primary School',
                        'secondary' => 'High School',
                        'tertiary' => 'Technical / Tertiary',
                        'bachelor' => 'Bachelor\'s Degree',
                        'master' => 'Master\'s Degree',
                        'phd' => 'PhD / Doctorate',
                    ])
                    ->required(),
                Select::make('professions')
                    ->label('Professions')
                    ->options([
                        'Student' => 'Student',
                        'Unemployed' => 'Unemployed',
                        'Worker' => 'Worker',
                        'Merchant' => 'Merchant',
                        'Entrepreneur' => 'Entrepreneur',
                        'Engineer' => 'Engineer',
                        'Architect' => 'Architect',
                        'Doctor' => 'Doctor',
                        'Lawyer' => 'Lawyer',
                        'Teacher' => 'Teacher',
                        'Artist' => 'Artist',
                        'Musician' => 'Musician',
                        'Athlete' => 'Athlete',
                        'Researcher' => 'Researcher',
                        'Programmer / Developer' => 'Programmer / Developer',
                        'Designer' => 'Designer',
                        'Other' => 'Other',
                    ])
                    //->columns(2)
                    //->bulkToggleable()
                    ->multiple()
                    ->required(),
                Select::make('investment_range')
                    ->options([
                        'less_than_5000' => 'Less than $5,000',
                        '5001-10000' => '$5,001 - $10,000',
                        '10001-25000' => '$10,001 - $25,000',
                        '25001-50000' => '$25,001 - $50,000',
                        '50001-100000' => '$50,001 - $100,000',
                        'more_than_100000' => 'More than $100,000',
                    ])
                    ->label('Investment Availability'),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            //->recordTitleAttribute('user_id')
            ->heading('About info')
            ->description('Tell me about you...')
            ->columns([
                TextColumn::make('musical_styles')->label('Musical Styles'),
                TextColumn::make('religion')->label('Religion')
                    ->formatStateUsing(fn($state) => [
                        'atheist/agnostic' => 'Atheist/Agnostic',
                        'satanist' => 'Satanist',
                        'pagan' => 'Pagan',
                        'jewish' => 'Jewish',
                        'islamic' => 'Islamic',
                        'christian' => 'Christian',
                        'other' => 'Other',
                    ][$state] ?? $state),
                TextColumn::make('education_level')->label('Education Level')
                    ->formatStateUsing(fn($state) => [
                        'none' => 'No formal education',
                        'primary' => 'Primary School',
                        'secondary' => 'High School',
                        'tertiary' => 'Technical / Tertiary',
                        'bachelor' => 'Bachelor\'s Degree',
                        'master' => 'Master\'s Degree',
                        'phd' => 'PhD / Doctorate',
                    ][$state] ?? $state),
                TextColumn::make('professions')->label('Professions'),
                TextColumn::make('investment_range')
                    ->label('Investment Availability')
                    ->formatStateUsing(fn($state) => [
                        'less_than_5000' => 'Less than $5,000',
                        '5001-10000' => '$5,001 - $10,000',
                        '10001-25000' => '$10,001 - $25,000',
                        '25001-50000' => '$25,001 - $50,000',
                        '50001-100000' => '$50,001 - $100,000',
                        'more_than_100000' => 'More than $100,000',
                    ][$state] ?? $state)
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make()
                    ->createAnother(false)
                    ->visible(fn($livewire) => $livewire->getOwnerRecord()->userAbout()->doesntExist()),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->paginated(false);
    }
}
