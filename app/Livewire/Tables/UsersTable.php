<?php

namespace App\Livewire\Tables;

use App\Models\User;
use Illuminate\Database\Eloquent\Builder;

class UsersTable extends BaseTable
{
    protected function baseQuery(): Builder
    {
        return User::query();
    }

    protected function searchableFields(): array
    {
        return ['name', 'email'];
    }

    protected function columns(): array
    {
        return [
            'name' => ['label' => 'Name', 'sortable' => true],
            'email' => ['label' => 'Email', 'sortable' => true],
            'actions' => [
                'label' => 'Actions',
                'view' => 'livewire.users.user-actions',
                'params' => [
                    'can_edit' => true
                ],
                'sortable' => false
            ],
            'created_at' => ['label' => 'Created At', 'sortable' => true],
        ];
    }
}
