<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TeacherResource\Pages;
use App\Filament\Resources\TeacherResource\RelationManagers;
use App\Models\Teacher;
use Barryvdh\DomPDF\Facade\Pdf;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Infolists\Components\Section;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Infolist;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Gate;

class TeacherResource extends Resource
{
    protected static ?string $model = Teacher::class;

    protected static ?string $navigationIcon = 'heroicon-o-users';

    protected static ?string $navigationGroup = 'Personal Data Managements';

    protected static ?int $navigationSort = 1;

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }

    public static function getNavigationBadgeColor(): string|array|null
    {
        return static::getModel()::count() > 50 ? 'warning' : 'primary';
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Main Details')
                    ->description('Teacher main details')
                    ->schema([
                        Forms\Components\Select::make('classroom_id')
                            ->relationship('classroom', 'name')
                            ->searchable()
                            ->preload()
                            ->native(false),
                        Forms\Components\Group::make([
                            Forms\Components\TextInput::make('first_name')
                                ->label('First Name')
                                ->required()
                                ->maxLength(255),
                            Forms\Components\TextInput::make('middle_name')
                                ->label('Middle Name')
                                ->maxLength(255),
                            Forms\Components\TextInput::make('last_name')
                                ->label('Last Name')
                                ->maxLength(255),
                        ])->columns(3),
                        Forms\Components\Group::make([
                            Forms\Components\TextInput::make('phone')
                                ->type('phone')
                                ->required()
                                ->maxLength(255),
                            Forms\Components\TextInput::make('address')
                                ->required()
                                ->maxLength(255),
                        ])->columns(2)
                    ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('classroom.name')
                    ->sortable()
                    ->placeholder('N/A'),
                Tables\Columns\TextColumn::make('name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('phone')
                    ->searchable(),
                Tables\Columns\TextColumn::make('address')
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
                Tables\Actions\Action::make('exportPdf')
                    ->label('Export PDF')
                    ->action(fn($record) => static::exportToPDF($record))
                    ->visible(fn($record) => Gate::allows('export', $record)),
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
                    ->description('Teacher main details')
                    ->schema([
                        TextEntry::make('classroom.name')
                            ->placeholder('N/A'),
                        TextEntry::make('name'),
                        TextEntry::make('phone'),
                        TextEntry::make('address'),
                    ])->columns(2)
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
            'index' => Pages\ListTeachers::route('/'),
            'create' => Pages\CreateTeacher::route('/create'),
            'view' => Pages\ViewTeacher::route('/{record}'),
            'edit' => Pages\EditTeacher::route('/{record}/edit'),
        ];
    }

    public static function exportToPdf($record)
    {
        if (!$record) {
            Notification::make()
                ->title('Export failed')
                ->body('No data found for export.')
                ->warning();
            return;
        }

        try {
            // Ambil data dari record
            $data = $record->toArray();

            // Buat PDF menggunakan view
            $pdf = Pdf::loadView('exports.teacher', ['data' => $data]);

            // Tentukan path file PDF
            $filePath = storage_path('app/exports/teacher-' . $record->id . '.pdf');

            // Buat direktori jika belum ada
            if (!is_dir(storage_path('app/exports'))) {
                mkdir(storage_path('app/exports'), 0755, true);
            }

            // Simpan file PDF
            $pdf->save($filePath);

            // Unduh file PDF dan hapus setelah diunduh
            return response()->download($filePath, 'teacher-' . $record->id . '.pdf')->deleteFileAfterSend();
        } catch (\Exception $e) {
            Notification::make()
                ->title('Export Error')
                ->body('An error occurred while exporting the data.')
                ->danger()
                ->send();
        }
    }
}