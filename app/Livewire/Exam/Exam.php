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
            // انتخاب نوع سوال به صورت رندم (1 تا 4)
            $questionType = rand(1, 4);

            // ساخت سوال بر اساس نوع
            // برای مثال، در نوع 1 سوال چندگزینه‌ای مانند پیاده‌سازی قبلی می‌شود:
            if($questionType == 1) {
                // در اینجا گزینه صحیح همان معنی کلمه است.
                $correctAnswer = $word->meaning;

                // انتخاب چند گزینه اشتباه از میان سایر کلمات کاربر
                $otherWords = Word::where('user_id', $word->user_id)
                                  ->where('id', '!=', $word->id)
                                  ->inRandomOrder()
                                  ->limit(3)
                                  ->get();
                $wrongOptions = $otherWords->pluck('meaning')->toArray();

                // ترکیب گزینه‌ها و مخلوط کردن آنها
                $options = array_merge([$correctAnswer], $wrongOptions);
                shuffle($options);

                $questionData = [
                    'type' => 1,
                    'word' => $word,
                    'options' => $options,
                    'correct' => $correctAnswer,
                ];
            }
            // در اینجا می‌توانید برای انواع دیگر سوال (2 تا 4) منطق دلخواهتان را پیاده‌سازی کنید.
            // به عنوان نمونه:
            elseif($questionType == 2) {
                // دریافت جمله از OpenAI
                $sentence = "";

                // اگر نتوانستیم جمله دریافت کنیم، یک جمله پیش‌فرض استفاده می‌کنیم
                if (!$sentence) {
                    $sentence = "Please use the word '{$word->word}' in the _____";
                }

                // ایجاد گزینه‌های اشتباه - حذف where type
                $otherWords = Word::where('user_id', $word->user_id)
                    ->where('id', '!=', $word->id)
                    ->inRandomOrder()
                    ->limit(3)
                    ->get();

                $wrongOptions = $otherWords->pluck('word')->toArray();
                $options = array_merge([$word->word], $wrongOptions);
                shuffle($options);

                $questionData = [
                    'type' => 2,
                    'word' => $word,
                    'prompt' => $sentence,
                    'options' => $options,
                    'correct' => $word->word
                ];
            }
            elseif($questionType == 3) {
                // سوال تطبیقی - نمایش چند کلمه و معنی آنها به صورت درهم
                $otherWords = Word::where('user_id', $word->user_id)
                    ->where('id', '!=', $word->id)
                    ->inRandomOrder()
                    ->limit(3)
                    ->get();

                $wordPairs = collect([$word])->merge($otherWords)->map(function($w) {
                    return [
                        'word' => $w->word,
                        'meaning' => $w->meaning
                    ];
                })->toArray();

                $words = collect($wordPairs)->pluck('word')->toArray();
                $meanings = collect($wordPairs)->pluck('meaning')->toArray();
                shuffle($meanings);

                $questionData = [
                    'type' => 3,
                    'word' => $word,
                    'wordPairs' => $wordPairs,
                    'words' => $words,
                    'meanings' => $meanings,
                    'correct' => $word->meaning
                ];
            }
            elseif($questionType == 4) {
                // فلش کارت با نمایش مثال و تلفظ
                $examples = json_decode($word->examples ?? '[]', true);
                $example = !empty($examples) ? $examples[array_rand($examples)] : null;

                $questionData = [
                    'type' => 4,
                    'word' => $word,
                    'prompt' => "What's the word for this meaning?",
                    'meaning' => $word->meaning,
                    'example' => $example,
                    'pronunciation' => $word->pronunciation ?? null,
                    'correct' => $word->word,
                ];
            }

            return $questionData;
        })->toArray();
    }

    // ثبت پاسخ کاربر برای سوال فعلی
    public function submitAnswer($answer = null)
    {
        if ($this->questions[$this->currentQuestionIndex]['type'] == 4) {
            $answer = $this->userInput;
            $this->userInput = ''; // پاک کردن input بعد از ثبت
        }

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
