<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});


Route::get('download/rep', function () {

    return response()->stream(function () {
        while (ob_get_level() > 0) {
            ob_end_flush();
        }

        foreach (range(1, 5) as $i) {
            echo "data: " . json_encode(['step' => $i]) . "\n\n";
            flush();
            sleep(1);
        }
    }, 200, [
        'Content-Type' => 'text/event-stream',
        'Cache-Control' => 'no-cache',
        'X-Accel-Buffering' => 'no', // for Nginx
    ]);

});