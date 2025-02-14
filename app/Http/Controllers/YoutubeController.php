<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use Symfony\Component\Process\Process;

class YoutubeController extends Controller
{
    public function download(Request $request){
        // dd($request);
        $url = $request->input('url');

        chdir('../public/storage/video');

        $process = new Process(["yt-dlp", "--output", "%(title)s.%(ext)s", $url]);
        $process->run();

        if (!$process->isSuccessful()){
            return Inertia::render( 'Download', [
                'filename' => "Please enter valid URL.",
                'downloadable' => false,
            ] );
        }

        $process = new Process(['yt-dlp', '--get-filename', "--output", "%(title)s.%(ext)s", $url]);
        $process->run();

        $filename = $process->getOutput();

        // dd($filename);
        return Inertia::render( 'Download', [
            'filename' => $filename,
            'downloadable' => true,
        ] );

    }
}
