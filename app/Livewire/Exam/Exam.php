<?php

namespace App\Livewire\Exam;

use Livewire\Component;
use App\Models\Word;
use Illuminate\Support\Facades\Auth;
use App\Services\OpenAIService;

class Exam extends Component
{
    public $isStarted = false;
    public $questions = [];
    public $userAnswers = [];
    public $currentQuestionIndex = 0;
    public $examFinished = false;
    public $score = 0;
    public $userInput = ''; // اضافه کردن متغیر
    public $currentQuestionAnswered = false;

    public function __construct()
    {

    }

    protected function getListeners()
    {
        return [
            'answer-submitted' => 'answerSubmitted',
            'next-question' => 'nextQuestion'
        ];
    }

    // شروع آزمون
    public function startExam()
    {
        $this->isStarted = true;
        $this->examFinished = false;
        $this->score = 0;
        $this->userAnswers = [];
        $this->currentQuestionIndex = 0;

        // انتخاب کلمات بر اساس سطح امتیاز
        $userId = Auth::id();

        $weakWords = Word::where('user_id', $userId)
            ->where('score', '<', 40)
            ->inRandomOrder()
            ->limit(6)
            ->get();

        $mediumWords = Word::where('user_id', $userId)
            ->whereBetween('score', [40, 70])
            ->inRandomOrder()
            ->limit(3)
            ->get();

        $goodWords = Word::where('user_id', $userId)
            ->where('score', '>', 70)
            ->inRandomOrder()
            ->limit(1)
            ->get();

        // ترکیب کلمات انتخاب شده
        $selectedWords = $weakWords->merge($mediumWords)->merge($goodWords);

        // ساخت سوالات به ازای هر کلمه
        $this->questions = $selectedWords->map(function($word) {
            return [
                'type' => 1,
                'word' => $word,
            ];
        })->toArray();
    }

    public function nextQuestion()
    {
        $this->currentQuestionAnswered = false;
        if($this->currentQuestionIndex < count($this->questions) - 1) {
            $this->currentQuestionIndex++;
        } else {
            $this->examFinished = true;
        }
    }

    public function answerSubmitted($isCorrect)
    {
        if($isCorrect) {
            $this->score++;
        }
        $this->currentQuestionAnswered = true;
    }

    public function render()
    {
        return view('livewire.exam.exam')->layout('layouts.front-app');
    }
}
