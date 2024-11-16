<?php

namespace App\Filament\Resources\TeacherResource\Pages;

use App\Filament\Resources\TeacherResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Filament\Resources\Pages\ListRecords\Tab;
use Illuminate\Database\Eloquent\Builder;

class ListTeachers extends ListRecords
{
    protected static string $resource = TeacherResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

    public function getTabs(): array
    {
        return [
            'All' => Tab::make(),
            'Homeroom Teacher' => Tab::make()
                ->query(fn(Builder $query) => $query->whereNotNull('classroom_id')),
            'Non Homeroom Teacher' => Tab::make()
                ->query(fn(Builder $query) => $query->whereNull('classroom_id')),
        ];
    }

    protected function getTableQuery(): Builder
    {
        $query = parent::getTableQuery();

        $activeTab = $this->getActiveTab();

        if ($activeTab === 'Homeroom Teacher') {
            $query->whereNotNull('classroom_id');
        } elseif ($activeTab === 'Non Homeroom Teacher') {
            $query->whereNull('classroom_id');
        }

        return $query;
    }

    protected function getActiveTab(): string
    {
        return $this->activeTab ?? 'All';
    }

    protected function setActiveTab(string $tab): void
    {
        $this->activeTab = $tab;
    }
}
