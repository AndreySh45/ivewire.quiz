<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Contracts\Repositories\QuestionsRepository;
use App\Repositories\Quiz\RedisQuestionsRepository;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->app->bind(QuestionsRepository::class, fn ($app) => new RedisQuestionsRepository()); //Объявление реализации Readis
    }
}
