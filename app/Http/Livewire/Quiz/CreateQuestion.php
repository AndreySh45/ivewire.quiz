<?php

namespace App\Http\Livewire\Quiz;

use Livewire\Component;
use App\DTO\Quiz\QuestionDto;
use App\Contracts\Repositories\QuestionsRepository;

class CreateQuestion extends Component
{
    public $question;
    public $options = []; //Хранение ответов
    public $right_answer;
    public $index = 0;

    protected $rules = [
        'question' => 'required',
        'options.*' => ['required', 'string', 'distinct'],
        'options' => ['required', 'array', 'min:4', 'max:5'],
        'right_answer' => 'required'
    ];

    protected $messages = [
        'question.required' => 'Вопрос обязателен для заполнения',
        'options.*.distinct' => 'Варианты ответов не должны совпадать',
        'options.*.required' => 'Ввод поля обязательно!',
        'options.max' => 'Вариантов ответов не должно быть больше пяти'
    ];

    public function updated($propertyName)
    {
        if (preg_match('/options\.[0-9]/', $propertyName)) {
            $this->validateOnly($propertyName);
        }
    }

    public function addEmptyOption()
    {
        $this->options[] = null;
    }

    public function saveQuestion(QuestionsRepository $questionsRepository)
    {
        $validatedData = $this->validate();
        $questionsRepository->addQuestion(new QuestionDto($validatedData));
        session()->flash('message', 'Вопрос успешно добавлен!');

        $this->reset(['question', 'options', 'right_answer']);
    }

    public function render()
    {
        return view('livewire.quiz.create-question');
    }
}
