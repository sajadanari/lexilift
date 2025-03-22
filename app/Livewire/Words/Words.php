<?php

namespace App\Livewire\Words;

use App\Models\Word;
use Livewire\Component;

class Words extends Component
{
    public $page = 'index';
    public $word;
    public $wordData = [
        'word' => '',
        'meaning' => '',
        'synonyms' => '',
        'antonyms' => '',
        'pronunciation' => '',
        'part_of_speech' => '',
        'usage' => '',
        'example' => '',
        'plural' => '',
        'countable' => true,
        'root' => '',
        'etymology' => '',
        'collocations' => '',
        'frequency' => '',
        'difficulty_level' => '',
        'notes' => '',
    ];

    protected $rules = [
        'wordData.word' => 'required|min:1|max:255',
        'wordData.meaning' => 'required',
        'wordData.synonyms' => 'nullable',
        'wordData.antonyms' => 'nullable',
        'wordData.pronunciation' => 'nullable|max:255',
        'wordData.part_of_speech' => 'nullable|max:255',
        'wordData.usage' => 'nullable',
        'wordData.example' => 'nullable',
        'wordData.plural' => 'nullable|max:255',
        'wordData.countable' => 'boolean',
        'wordData.root' => 'nullable|max:255',
        'wordData.etymology' => 'nullable',
        'wordData.collocations' => 'nullable',
        'wordData.frequency' => 'nullable|max:255',
        'wordData.difficulty_level' => 'nullable|max:255',
        'wordData.notes' => 'nullable',
    ];

    protected $listeners = [
        'edit-word' => 'editWord',
        'delete-word' => 'deleteWord',
    ];

    public function showCreatePage()
    {
        $this->page = 'create';
    }

    public function showIndexPage()
    {
        $this->page = 'index';
    }

    /**
     * Edit word with the given ID
     */
    public function editWord($wordId)
    {
        $this->word = Word::findOrFail($wordId);
        $this->wordData = $this->word->toArray();
        $this->page = 'edit';
    }

    /**
     * Delete word with the given ID
     */
    public function deleteWord($wordId)
    {
        $word = Word::findOrFail($wordId);
        $word->delete();
        $this->dispatch('table-refresh');
        session()->flash('message', 'Word deleted successfully!');
    }

    public function save()
    {
        $this->validate();

        if ($this->page === 'edit') {
            $this->word->update($this->wordData);
        } else {
            Word::create($this->wordData);
        }

        $this->reset('wordData');
        $this->page = 'index';
        session()->flash('message', 'Word saved successfully!');
    }

    public function render()
    {
        return view('livewire.words.words');
    }
}
