<?php

declare(strict_types=1);

namespace App\Contracts\Repositories;

interface QuestionsRepository
{
    public function all(): array; // Получение всех вопросов в виде массива

    public function addQuestion(array $newQuestion); //Добавление нового вопроса
}
