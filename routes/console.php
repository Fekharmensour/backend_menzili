<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;
use App\Jobs\ExpireBoosts;
use App\Jobs\RecalculateRankingScores;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

// Boost System Scheduler
Schedule::job(new ExpireBoosts())->hourly();
Schedule::job(new RecalculateRankingScores())->daily()->at('02:00');
