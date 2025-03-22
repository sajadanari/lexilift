<?php

namespace App\Livewire\Users;

use App\Models\User;
use Livewire\Component;
use Illuminate\Support\Facades\Hash;

class Users extends Component
{
    public $page = 'index';
    public $user;
    public $allUsers;
    public $userData = [
        'name' => '',
        'email' => '',
        'password' => '',
    ];

    protected $rules = [
        'userData.name' => 'required|min:1|max:255',
        'userData.email' => 'required',
        'userData.password' => 'nullable',
    ];

    public function showCreatePage()
    {
        $this->page = 'create';
    }

    public function showIndexPage()
    {
        $this->page = 'index';
    }

    public function editUser($userID)
    {
        $this->user = User::findOrFail($userID);
        $this->userData = $this->user->toArray();
        $this->page = 'edit';
    }

    public function deleteUser($userID)
    {
        User::findOrFail($userID)->delete();
        session()->flash('message', 'User deleted successfully!');
        $this->dispatch('table-refresh');
    }

    public function save()
    {
        if ($this->page === 'create') {
            $this->rules['userData.password'] = 'required';
        }

        $this->validate();

        if (!empty($this->userData['password'])) {
            $this->userData['password'] = Hash::make($this->userData['password']);
        } else {
            unset($this->userData['password']);
        }

        if ($this->page === 'edit') {
            $this->user->update($this->userData);
        } else {
            User::create($this->userData);
        }

        $this->reset('userData');
        $this->page = 'index';
        session()->flash('message', 'User saved successfully!');
    }

    public function mount()
    {
        $this->allUsers = User::all();
    }

    public function render()
    {
        return view('livewire.users.users');
    }
}
