<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Schedule::command('rdv:send-reminders')->dailyAt('20:17');
//pour le test 
// Schedule::command('rdv:send-reminders')
//     ->timezone('Africa/Casablanca')
//     ->everyMinute();