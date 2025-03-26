<?php

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote')->hourly();

app()->singleton(Schedule::class, function ($app) {
    return tap(new Schedule, function (Schedule $schedule) {
        $schedule->command('app:dispatch-release-expired-requests')
            ->everyMinute()
            ->withoutOverlapping();
    });
});
