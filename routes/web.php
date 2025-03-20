<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\YoutubeController;
use App\Models\User;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


Route::get('/', function (Request $request) {
    return Inertia::render('Home',[
                'users'=>User::when($request->search, function($query) use($request) {
                        $query->where('name','like', "%". $request->search . "%");
                    })->paginate(5)->withQueryString(),
                'searchTerm' => $request->search,
                'can' => [
                    'delete_user' => Auth::user() ? Auth::user()->can('delete', User::class): null
                ]
        ]);
})->name('home');

// Route::get('/', function(){
//     return view('welcome');
// });


Route::inertia('/about','About',['user'=>'Yi'])->name('about');

Route::middleware('guest')->group( function(){
    Route::inertia('/register','Auth/Register')->name('register');
    Route::post('/register', [AuthController::class, 'register']);
    
    Route::inertia('/login', 'Auth/Login')->name('login');
    Route::post('/login', [AuthController::class, 'login']);
});


Route::middleware('auth')->group( function(){
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::post('/delete',[
        AuthController::class, 'delete'])->name('delete');
    Route::inertia('/dashboard', 'Dashboard')->name('dashboard');
    
    // Handling YoutubeDownload
    Route::get('/download/{filename}', function ($filename){
        return response()->download(public_path('/storage/video/' . $filename));
    })->where('filename', '.*');
    Route::post('/download',[YoutubeController::class, 'download']);
    Route::inertia('/download','Download')->name('download');
});


// Handle Facebook Webhook
Route::match (['get','post'],'/webhook', function (Request $request) {
    // handle get request
    if ($request->isMethod('get')) {
        Log::info('Facebook Webhook Received:', $request->all());
        $challenge = $request->input('hub_challenge');
        $verify_token = $request->input('hub_verify_token');
        if ($verify_token === 'yee0x44f') {
            return response($challenge, 200);
        }
        return response('Forbidden', 403);
    }
    else if ($request->isMethod('post')) {
        $data = $request->all();
        Log::info('Facebook Webhook Received:', $data);
        if (!isset($data['entry'])) {
            return response()->json(['message' => 'Invalid webhook event'], 400);
        }
        foreach ($data['entry'] as $entry) {
            foreach ($entry['messaging'] ?? [] as $event) {
                if (isset($event['message'])) {
                    Log::info('Received message:', $event['message']);
                    // Process messages here
                } elseif (isset($event['postback'])) {
                    Log::info('Received postback:', $event['postback']);
                    // Process postbacks here
                }
            }
        }
        return response()->json(['status' => 'success']);
    }
});

