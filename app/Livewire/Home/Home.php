<?php

namespace App\Livewire\Home;

use Livewire\Component;
use App\Models\Word;
use App\Enums\WordLevel;
use Illuminate\Support\Facades\Cache;

/**
 * Home Component
 *
 * Handles the main landing page functionality including:
 * - User statistics display
 * - Testimonial submission
 * - Progress tracking visualization
 *
 * @package App\Livewire\Home
 */
class Home extends Component
{
    /**
     * User rating input for testimonial
     * @var int
     */
    public $rating = 0;

    /**
     * User review text for testimonial
     * @var string
     */
    public $review = '';

    /**
     * Get user's vocabulary statistics
     *
     * Retrieves and caches user statistics including:
     * - Total words count
     * - Mastered words count
     * - Learning words count
     * - Words needing practice count
     *
     * @return array|null Statistics array or null if user not authenticated
     */
    public function getStatistics(): ?array
    {
        $user = auth()->user();
        if (!$user) return null;

        return Cache::remember('user_statistics_' . $user->id, 300, function () use ($user) {
            return [
                'total_words' => $user->words()->count(),
                'mastered_words' => $user->words()
                    ->whereBetween('score', WordLevel::STRONG->getRange())
                    ->count(),
                'learning_words' => $user->words()
                    ->whereBetween('score', WordLevel::MEDIUM->getRange())
                    ->count(),
                'weak_words' => $user->words()
                    ->whereBetween('score', WordLevel::WEAK->getRange())
                    ->count(),
            ];
        });
    }

    /**
     * Handle testimonial submission
     *
     * Validates and processes user testimonial submission
     * Displays success message upon completion
     *
     * @return void
     */
    public function submitTestimonial(): void
    {
        $this->validate([
            'rating' => 'required|integer|min:1|max:5',
            'review' => 'required|string|min:10|max:500'
        ]);

        // TODO: Implement testimonial storage in database
        // Testimonial::create([
        //     'user_id' => auth()->id(),
        //     'rating' => $this->rating,
        //     'review' => $this->review
        // ]);

        $this->reset(['rating', 'review']);
        session()->flash('message', 'Thank you for your feedback!');
    }

    /**
     * Render the component
     *
     * @return \Illuminate\View\View
     */
    public function render()
    {
        return view('livewire.home.home', [
            'statistics' => $this->getStatistics()
        ])->layout('layouts.front-app');
    }
}
