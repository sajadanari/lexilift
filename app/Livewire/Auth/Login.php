<?php

namespace App\Livewire\Auth;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class Login extends Component
{
    // Form fields
    public $email = '';
    public $password = '';

    // Validation rules
    protected $rules = [
        'email' => 'required|email',
        'password' => 'required|min:8',
    ];

    // Custom error messages
    protected $messages = [
        'email.required' => 'Email address is required',
        'email.email' => 'Please enter a valid email address',
        'password.required' => 'Password is required',
        'password.min' => 'Password must be at least 8 characters',
    ];

    /**
     * Handle the login form submission
     */
    public function login()
    {
        // Validate form inputs
        $this->validate();

        // Attempt to authenticate user
        if (Auth::attempt(['email' => $this->email, 'password' => $this->password])) {
            // Authentication successful
            session()->regenerate();
            
            // Redirect to dashboard or intended URL
            return redirect()->intended(route('home'));
        }

        // Authentication failed
        $this->addError('email', 'Invalid credentials. Please try again.');
        
        // Clear password field
        $this->password = '';
    }

    public function logout()
    {
        Auth::logout();
        session()->invalidate();
        session()->regenerateToken();
        
        return redirect()->route('home');
    }

    public function render()
    {
        return view('livewire.auth.login');
    }
}