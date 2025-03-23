<?php

namespace App\Livewire\Exam;

use Livewire\Component;
use App\Models\Word;
use Illuminate\Support\Facades\Auth;

class Exam extends Component
{
    public $isStarted = false;
    public $questions = [];
    public $userAnswers = [];
    public $currentQuestionIndex = 0;
    public $examFinished = false;
    public $score = 0;

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
                // آرایه‌ای از الگوهای جمله برای سوالات تکمیل جمله
                $sentenceTemplates = [
                    "The weather was so hot that the ice cream started to ______ quickly.",
                    "Students must ______ hard to improve their vocabulary.",
                    "I couldn't ______ what she was saying because of the noise.",
                    "It's important to ______ your goals clearly.",
                    "She likes to ______ in the garden during weekends."
                ];

                // انتخاب یک جمله تصادفی
                $randomTemplate = $sentenceTemplates[array_rand($sentenceTemplates)];

                // ایجاد گزینه‌های اشتباه
                $otherWords = Word::where('user_id', $word->user_id)
                    ->where('id', '!=', $word->id)
                    ->where('type', $word->type) // کلمات هم‌نوع
                    ->inRandomOrder()
                    ->limit(3)
                    ->get();

                $wrongOptions = $otherWords->pluck('word')->toArray();
                $options = array_merge([$word->word], $wrongOptions);
                shuffle($options);

                $questionData = [
                    'type' => 2,
                    'word' => $word,
                    'prompt' => $randomTemplate,
                    'options' => $options,
                    'correct' => $word->word
                ];
            }
            elseif($questionType == 3) {
                // سوال تطبیقی (matching) – در این نمونه ساده، می‌توان یک نمونه از چندگزینه‌ای متفاوت ارائه داد
                $correctAnswer = $word->meaning;
                $otherWords = Word::where('user_id', $word->user_id)
                                  ->where('id', '!=', $word->id)
                                  ->inRandomOrder()
                                  ->limit(3)
                                  ->get();
                $wrongOptions = $otherWords->pluck('meaning')->toArray();
                $options = array_merge([$correctAnswer], $wrongOptions);
                shuffle($options);

                $questionData = [
                    'type' => 3,
                    'word' => $word,
                    'options' => $options,
                    'correct' => $correctAnswer,
                ];
            }
            elseif($questionType == 4) {
                // فلش کارت ساده: نمایش معنی و درخواست وارد کردن کلمه صحیح
                $questionData = [
                    'type' => 4,
                    'word' => $word,
                    'prompt' => "Enter the correct word for the meaning: '{$word->meaning}'.",
                    'correct' => $word->word,
                ];
            }

            return $questionData;
        })->toArray();
    }

    // ثبت پاسخ کاربر برای سوال فعلی
    public function submitAnswer($answer)
    {
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
