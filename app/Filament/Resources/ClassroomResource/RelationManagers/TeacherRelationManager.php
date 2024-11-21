<?php

namespace App\Filament\Resources\ClassroomResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Infolists\Components\Group;
use Filament\Infolists\Components\TextEntry;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class TeacherRelationManager extends RelationManager
{
    protected static string $relationship = 'teacher';

    protected static ?string $title = 'Homeroom Teacher';


    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('name')
            ->columns([
                Tables\Columns\TextColumn::make('name'),
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
                Tables\Actions\ViewAction::make()
                    ->modalHeading('Teacher Details')
                    ->modalSubheading(fn($record) => "Details for {$record->name}")
                    ->infolist([
                        Group::make([
                            TextEntry::make('id')
                                ->label('Teacher ID')
                                ->url(fn($record) => route('filament.admin.resources.teachers.view', $record->id))
                                ->openUrlInNewTab(),
                            TextEntry::make('name')
                                ->label('Teacher Name')
                                ->url(fn($record) => route('filament.admin.resources.teachers.view', $record->id))
                                ->openUrlInNewTab(),
                        ])->columns(2)
                    ]),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
