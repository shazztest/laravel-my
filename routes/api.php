<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Http\Controllers\PostController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware('auth:api')->group(function(){
    Route::get('/posts',[PostController::class, 'index']);
});

Route::post('/login', function(Request $request){
    $request->validate([
        'email' => 'required|email',
        'password' => 'required'
    ]);
    $credentials = $request->only('email','password');

    if(Auth::attempt($credentials)){
        $user = Auth::user();
        $token = $user->createToken('Personal Access Token')->accessToken;
        return response()->json(['token'=>$token]);
    }else{
        return response()->json(['erron'=>'Unauthorized'],401);
    }
});

Route::get('/register', function(Request $request){
    return User::create([
        'name' => 'dev',
        'email' => 'dev@example.com',
        'password' => '123456',
    ]);
});



Route::post('/login', function(Request $request){
    $request->validate([
        'email' => 'required|email',
        'password' => 'required'
    ]);
    $credentials = $request->only('email','password');

    if(Auth::attempt($credentials)){
        $user = Auth::user();
        $token = $user->createToken($user->email)->accessToken;
        return response()->json(['token'=>$token]);
    }else{
        return response()->json(['erron'=>'Unauthorized'],401);
    }
});