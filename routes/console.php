<?php

use Illuminate\Support\Facades\Artisan;

Artisan::command('AarogyaCare:health', function (): void {
    $this->info('AarogyaCare foundation is ready.');
})->purpose('Check the AarogyaCare application foundation.');
