<?php

declare(strict_types=1);

namespace App\Repositories\Quiz;

use App\DTO\Quiz\QuestionDto;
use Illuminate\Support\Facades\Redis;
use App\Contracts\Repositories\QuestionsRepository;

class RedisQuestionsRepository implements QuestionsRepository
{
    const KEY = 'quiz.questions'; //Хранение названия ключа Redis

    private $redis; // Соединение с Redis

    public function __construct()
    {
        $this->redis = Redis::connection();
    }

    public function all(): array
    {
        if (empty($this->redis->keys(self::KEY))) {
            return []; //Если нет данных в Redis возвращаем пустой массив
        }
        return json_decode($this->redis->get(self::KEY), true);
    }

    public function addQuestion(QuestionDto $questionDto)
    {
        $all = $this->all();
        $all[] = $questionDto->toArray();
        $result = json_encode($all);

        $this->redis->del(self::KEY);
        $this->redis->set(self::KEY, $result);
    }
}
