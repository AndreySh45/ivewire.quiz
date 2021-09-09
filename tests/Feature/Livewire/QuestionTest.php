<?php

namespace Tests\Feature\Livewire;

use Tests\TestCase;
use Livewire\Livewire;
use Mockery\MockInterface;
use App\Http\Livewire\Quiz\Question;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Contracts\Repositories\QuestionsRepository;


class QuestionTest extends TestCase
{

    use WithFaker;

    /**
     * A basic feature test example.
     *
     * @return void
     */

    public function test_get_current_result(): void
    {
        $fakeQuestions = $this->fakeQuestions();
        $this->instance(
            QuestionsRepository::class,
            \Mockery::mock(QuestionsRepository::class, fn (
                MockInterface $mock
            ) => $mock->shouldReceive('all')->once()->andReturn($fakeQuestions))
        );

        Livewire::test(Question::class)
                  ->call('loadQuestion')
                  ->call('getCurrentResult')
                  ->assertSee(sprintf('Всего %s из %s', 0, count($fakeQuestions))); //Проверка есть ли такая строка в макете?
            // Всего 0 из 2
    }

    // Тест результатов прохождения викторины
    public function test_get_result(): void
    {
        $fakeQuestions = $this->fakeQuestions(1);
        $this->instance(
            QuestionsRepository::class,
            \Mockery::mock(QuestionsRepository::class, fn (
                MockInterface $mock
            ) => $mock->shouldReceive('all')->once()->andReturn($fakeQuestions))
        );
        Livewire::test(Question::class)
            ->call('loadQuestion')
            ->set('answer', 1) //Установка свойства
            ->call('next') //вызов метода
            ->assertViewHas('answer', null) //Проверка сброса после результата
            ->assertDispatchedBrowserEvent('toast', ['title' => 'Уведомление', 'message' => 'Тест пройден']) // Отпправление события в браузер
//            ->assertEmitted('toast')
            ->assertViewIs('livewire.quiz.question')
            ->assertSee('Всего правильных ответов')
            ->assertSee('Всего вопросов ' . count($fakeQuestions)); // Проверка вывода результата
//            ->assertSeeInOrder(['Всего правильных ответов', 'Всего вопросов ' . count($fakeQuestions)])

    }


    //Генерация фейковых данных
    public function fakeQuestions(int $maxQuestions = 5): array
    {
        $questions = [];
        for ($i = 0; $i < $maxQuestions; $i++) {
            $questions[] = [
                'question' => $this->faker->word,
                'options' => [
                    $this->faker->word,
                    $this->faker->word,
                    $this->faker->word,
                    $this->faker->word,
                ],
                'right_answer' => $this->faker->numberBetween(0, 3)
            ];
        }
        return $questions;
    }
}
