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
        $format = $request->input('format');

        chdir('../public/storage/video');

        if($format=='mp4'){
            $process = new Process(["yt-dlp","--format","mp4", "--output", "%(title)s.%(ext)s", $url]);
            $process->run();
        } else if($format=='mp3'){
            $process = new Process(["yt-dlp","-x", "--audio-format","mp3", "--output", "%(title)s.%(ext)s", $url]);
            $process->run();
        }

        if (!$process->isSuccessful()){
            return Inertia::render( 'Download', [
                'filename' => "Please enter valid URL.",
                'downloadable' => false,
            ] );
        }
        $output = $process->getOutput();

        if (preg_match('/\[download\] (.+?) has already been downloaded/', $output, $matches) ||
            preg_match('/\[download\] Destination: (.+)/', $output, $matches)) {
            $filename = trim($matches[1]);
        }else{
            return Inertia::render( 'Download', [
                'filename' => "Error. Please try again.",
                'downloadable' => false,
            ] );
        };

        return Inertia::render( 'Download', [
            'filename' => $filename,
            'downloadable' => true,
        ] );

    }
}
