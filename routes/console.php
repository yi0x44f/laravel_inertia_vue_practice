<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;
use Illuminate\Support\Facades\File;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote')->hourly();

Schedule::call( function(){
    // Storage::makeDirectory( public_path('/storage/video') );
    // $files = Storage::disk('public')->allFiles('storage/video');
    // Storage::disk('public')->delete($files);
    File::cleanDirectory(public_path('/storage/video'));
} )->everySixHours();