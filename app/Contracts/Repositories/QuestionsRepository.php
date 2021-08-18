<?php

declare(strict_types=1);

namespace App\Contracts\Repositories;

use App\DTO\Quiz\QuestionDto;

interface QuestionsRepository
{
    public function all(): array; // Получение всех вопросов в виде массива

    public function addQuestion(QuestionDto $questionDto); //Добавление нового вопроса
}
