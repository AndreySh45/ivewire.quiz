<?php

namespace App\Http\Livewire\Quiz;

use Livewire\Component;
use App\Contracts\Repositories\QuestionsRepository;

class Question extends Component
{

    public string $question;
    public array $options;
    public $answer;

    public function mount(QuestionsRepository $questionsRepository)
    {
        $questions = $questionsRepository->all();
        $this->question = $questions[1]['question'];
        $this->options = $questions[1]['options'];
    }


    public function render()
    {
        return view('livewire.quiz.question')->extends('layouts.app');
    }
}
