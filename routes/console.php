<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

// Agendamento: Executa todo dia à meia-noite
Schedule::command('parcelas:enviar-emails')
    ->daily()
    ->at('00:00')
    ->timezone('America/Sao_Paulo');
