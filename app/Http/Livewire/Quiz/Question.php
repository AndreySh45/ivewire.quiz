<?php

namespace App\Http\Livewire\Quiz;

use Livewire\Component;
use App\Contracts\Repositories\QuestionsRepository;

class Question extends Component
{

    public string $question;
    public array $options =[];
    public $answer;
    public $keyCurrentQuestion; //ключ текущего вопроса
    public $questions;
    public $result; //Результат

    /**
     * @var mixed|string
     */
    public $currentResult;

    public function mount(QuestionsRepository $questionsRepository)
    {
        $this->questions = $questionsRepository->all();
    }

    public function loadQuestion()
    {
        $this->toggleQuestion();
    }

    public function getQuestions(QuestionsRepository $questionsRepository)
    {
        $this->questions = $questionsRepository->all();
    }

    public function getCurrentResult()
    {
        $this->currentResult = sprintf('Всего %s из %s', $this->keyCurrentQuestion,  count($this->questions));
    }

    public function toggleQuestion() //смена указателя на следующий вопрос
    {
        $currentQuestion = null; // Есть ли еще вопросы или нет?
        foreach ($this->questions as $key => $question) {
            if (!array_key_exists('passed', $question)) { // Если ключ passed отсутствует, значит мы нашли крайний, не спрошенный вопрос
                $currentQuestion = $question;
                $this->keyCurrentQuestion = $key; // Ключ текущего вопроса
                $this->question = $currentQuestion['question'];
                $this->options = $currentQuestion['options'];
                break;
            }
        }
        if (is_null($currentQuestion)) { //Если вопрпосов не осталось, подсчитаем все ответы
            $this->result = $this->calculateRightAnswers($this->questions);
            //$this->emit('quizPassed');
            //$this->emit('quizPassed', 'Уведомление', 'Тест пройден!');
            $this->dispatchBrowserEvent('toast', ['title' => 'Уведомление', 'message' => 'Тест пройден']);
        }
    }

    public function calculateRightAnswers(array $questions)
    {
        return array_reduce($questions, function ($carry, $question) {
            if ($question['answer_got'] == $question['right_answer']) {
                $carry = $carry + 1;
            }
            return $carry;
        }, 0);
    }


    public function next()
    {
        $this->questions[$this->keyCurrentQuestion] = array_merge($this->questions[$this->keyCurrentQuestion], [
           'passed' => true, 'answer_got' => $this->answer
        ]);
        $this->toggleQuestion();
        $this->reset('answer'); //Сброс результата предыдущего ответа
    }

    public function render()
    {
        return view('livewire.quiz.question')->extends('layouts.app');
    }
}
