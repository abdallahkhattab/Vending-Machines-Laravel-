<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Livewire\Livewire;

Route::get('/', function () {
    return view('welcome');
});
Route::get('/token', function (Request $request) {
    $token = csrf_token(); // or: $request->session()->token();
    return response($token);
});


Route::get('/test-csrf', function () {
    return response()->json([
        'csrf_token' => csrf_token(),
        'session_id' => session()->getId(),
        'app_url' => config('app.url'),
        'session_domain' => config('session.domain')
    ]);
});

Route::get('/debug-cookies', function () {
    $response = response()->json([
        'session_id' => session()->getId(),
        'csrf_token' => csrf_token(),
        'cookies' => request()->cookies->all(),
        'session_lifetime' => config('session.lifetime'),
        'session_secure' => config('session.secure'),
        'session_same_site' => config('session.same_site'),
        'app_env' => config('app.env'),
    ]);
    
    // Also set a test cookie
    return $response->cookie('test_cookie', 'test_value', 60, '/', '.nawasrah.site', true, true);
});

// to fix the 419 error and change of used livewire js path
Livewire::setScriptRoute(function($handle) {
    return Route::get(env("LIVEWIRE_BASE_PATH" , ""). '/livewire/livewire.js', $handle);
});
// to fix the 419 error and change of used livewire js path
Livewire::setUpdateRoute(function($handle) {
    return Route::get( env("LIVEWIRE_BASE_PATH" , ""). '/livewire/update', $handle);
});
