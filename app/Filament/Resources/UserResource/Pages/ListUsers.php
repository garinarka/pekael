<?php

namespace App\Filament\Resources\UserResource\Pages;

use App\Filament\Resources\UserResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Filament\Resources\Pages\ListRecords\Tab;
use Illuminate\Database\Eloquent\Builder;

class ListUsers extends ListRecords
{
    protected static string $resource = UserResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

    public function getTabs(): array
    {
        return [
            'All' => Tab::make()
                ->badge(fn() => $this->getUserCount()),
            'Admins' => Tab::make()
                ->query(fn(Builder $query) => $query->where('role', 'admin'))
                ->badge(fn() => $this->getUserCount('admin')),
            'Teachers' => Tab::make()
                ->query(fn(Builder $query) => $query->where('role', 'teacher'))
                ->badge(fn() => $this->getUserCount('teacher')),
            'Students' => Tab::make()
                ->query(fn(Builder $query) => $query->where('role', 'student'))
                ->badge(fn() => $this->getUserCount('student')),
        ];
    }

    protected function getUserCount(?string $role = null): int
    {
        $query = static::getResource()::getEloquentQuery();

        if ($role) {
            $query->where('role', $role);
        }

        return $query->count();
    }

    protected function getTableQuery(): Builder
    {
        $query = parent::getTableQuery();
        $activeTab = $this->getActiveTab();

        if ($activeTab === 'Admins') {
            $query->where('role', 'admin');
        } elseif ($activeTab === 'Teachers') {
            $query->where('role', 'teacher');
        } elseif ($activeTab === 'Students') {
            $query->where('role', 'student');
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
