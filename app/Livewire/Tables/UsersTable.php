<?php

namespace App\Livewire\Tables;

use App\Models\User;
use Livewire\Component;

class UsersTable extends Component
{
    public $users;

    public function mount()
    {
        $this->users = User::all();
    }

    public function render()
    {
        return view('livewire.tables.users-table.users-table');
    }
}
