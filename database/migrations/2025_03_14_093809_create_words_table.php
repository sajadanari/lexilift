<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('words', function (Blueprint $table) {
            $table->id();
            $table->string('word'); // The main word
            $table->text('meaning'); // Word meaning (with comprehensive description)
            $table->text('synonyms')->nullable(); // Synonyms (can store multiple words)
            $table->text('antonyms')->nullable(); // Antonyms
            $table->string('pronunciation')->nullable(); // Pronunciation (e.g., IPA or text)
            $table->string('part_of_speech')->nullable(); // Part of speech (noun, verb, adjective, etc.)
            $table->text('usage')->nullable(); // Word usage in sentences or usage notes
            $table->text('example')->nullable(); // Example sentences using the word
            $table->string('plural')->nullable(); // Plural form if applicable
            $table->boolean('countable')->default(true); // Whether the noun is countable or uncountable
            $table->string('root')->nullable(); // Word root if available
            $table->text('etymology')->nullable(); // Etymology and word history
            $table->text('collocations')->nullable(); // Common phrases or collocations
            $table->string('audio')->nullable(); // Path or link to pronunciation audio file
            $table->string('frequency')->nullable(); // Word frequency (e.g., high, medium, low, or numeric)
            $table->string('difficulty_level')->nullable(); // Word difficulty level (e.g., A1, A2, B1, B2, C1, C2)
            $table->text('notes')->nullable(); // Additional notes or remarks
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('words');
    }
};
