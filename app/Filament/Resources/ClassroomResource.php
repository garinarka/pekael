<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Paralel;
use Filament\Forms\Form;
use App\Models\Classroom;
use App\Models\Department;
use Filament\Tables\Table;
use Filament\Infolists\Infolist;
use Filament\Resources\Resource;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Filament\Infolists\Components\Section;
use Filament\Infolists\Components\TextEntry;
use App\Filament\Resources\ClassroomResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\ClassroomResource\RelationManagers;
use App\Filament\Resources\ClassroomResource\RelationManagers\StudentsRelationManager;
use App\Filament\Resources\ClassroomResource\RelationManagers\TeacherRelationManager;

class ClassroomResource extends Resource
{
    protected static ?string $model = Classroom::class;

    protected static ?string $navigationIcon = 'heroicon-o-building-office';

    protected static ?string $navigationGroup = 'School Managements';

    protected static ?int $navigationSort = 1;

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }

    public static function getNavigationBadgeColor(): string|array|null
    {
        return static::getModel()::count() > 25 ? 'warning' : 'primary';
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Main Details')
                    ->description('Classroom main details')
                    ->schema([
                        Forms\Components\Select::make('level')
                            ->required()
                            ->options([
                                'X' => 'X',
                                'XI' => 'XI',
                                'XII' => 'XII',
                                'XIII' => 'XIII'
                            ])
                            ->searchable()
                            ->preload()
                            ->native(false),
                        Forms\Components\Select::make('department')
                            ->required()
                            ->options(Department::all()->pluck('name', 'name'))
                            ->searchable()
                            ->preload()
                            ->native(false),
                        Forms\Components\Select::make('paralel')
                            ->required()
                            ->options(Paralel::all()->pluck('name', 'name'))
                            ->searchable()
                            ->preload()
                            ->native(false)
                            ->columnSpanFull(),
                    ])->columns(2)
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                Section::make('Main details')
                    ->description('Classroom main details')
                    ->schema([
                        TextEntry::make('teacher.name'),
                        TextEntry::make('name'),
                    ])->columns(2)
            ]);
    }

    public static function getRelations(): array
    {
        return [
            TeacherRelationManager::class,
            StudentsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListClassrooms::route('/'),
            'create' => Pages\CreateClassroom::route('/create'),
            'view' => Pages\ViewClassroom::route('/{record}'),
            'edit' => Pages\EditClassroom::route('/{record}/edit'),
        ];
    }
}
