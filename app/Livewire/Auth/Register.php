<?php

namespace App\Livewire\Auth;

use App\Models\User;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class Register extends Component
{
    // Form fields
    public $name = '';
    public $email = '';
    public $password = '';
    public $password_confirmation = '';

    // Validation rules
    protected $rules = [
        'name' => 'required|min:3',
        'email' => 'required|email|unique:users',
        'password' => 'required|min:8|confirmed',
        'password_confirmation' => 'required'
    ];

    // Custom error messages
    protected $messages = [
        'name.required' => 'Name is required',
        'name.min' => 'Name must be at least 3 characters',
        'email.required' => 'Email address is required',
        'email.email' => 'Please enter a valid email address',
        'email.unique' => 'This email is already registered',
        'password.required' => 'Password is required',
        'password.min' => 'Password must be at least 8 characters',
        'password.confirmed' => 'Passwords do not match',
    ];

    /**
     * Handle the registration form submission
     */
    public function register()
    {
        // Validate form inputs
        $this->validate();

        // Create new user
        $user = User::create([
            'name' => $this->name,
            'email' => $this->email,
            'password' => Hash::make($this->password),
        ]);

        // Login the user
        Auth::login($user);

        // Regenerate session
        session()->regenerate();

        // Redirect to dashboard
        return redirect()->intended(route('home'));
    }

    public function render()
    {
        return view('livewire.auth.register')->layout('layouts.auth-app');
    }
}
