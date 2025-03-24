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

    public function __construct()
    {

    }

    protected function getListeners()
    {
        return ['answer-submitted' => 'submitAnswer'];
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
                'correct' => $word->meaning,
            ];
        })->toArray();
    }

    // ثبت پاسخ کاربر برای سوال فعلی
    public function submitAnswer($data)
    {
        $answer = $data['answer'];

        // ذخیره پاسخ کاربر در آرایه userAnswers
        $this->userAnswers[$this->currentQuestionIndex] = $answer;

        // بررسی پاسخ فعلی و به‌روزرسانی امتیاز کلمه مربوطه
        $question = $this->questions[$this->currentQuestionIndex];
        $word = $question['word'];

        if(trim(strtolower($answer)) == trim(strtolower($question['correct']))) {
            // پاسخ صحیح: افزایش امتیاز کلمه (مثلاً +5)
            $word->score = $word->score + 5;
            $this->score++;
        } else {
            // پاسخ غلط: کاهش امتیاز کلمه (مثلاً -3)
            $word->score = max(0, $word->score - 3);
        }
        // ذخیره تغییرات در دیتابیس
        $word->save();

        // رفتن به سوال بعدی
        if($this->currentQuestionIndex < count($this->questions) - 1) {
            $this->currentQuestionIndex++;
        } else {
            // پایان آزمون
            $this->examFinished = true;
        }
    }

    public function render()
    {
        return view('livewire.exam.exam')->layout('layouts.front-app');
    }
}
