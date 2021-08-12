<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Contracts\Repositories\QuestionsRepository;

class QuestionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */


    private array $questions = [
        [
            'question' => 'Какая площадь Российской Федерации?',
            'options' => [
                '17 098 246 км²',
                '18 400 222 км²',
                '13 200 000 км²',
                '12 000 232 км²'
            ],
            'right_answer' => 1
        ],
        [
            'question' => 'Какое население России?',
            'options' => [
                '145 975 300',
                '120 175 200',
                '111 900 123',
                '149 345 500'
            ],
            'right_answer' => 0
        ]
    ];

    public function run(QuestionsRepository $questionsRepository)
    {
        foreach ($this->questions as $question) {
            $questionsRepository->addQuestion($question);
        }
    }
}
