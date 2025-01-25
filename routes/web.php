<?php

use App\Http\Controllers\WeatherHistoryController;
use App\Models\WeatherHistory;
use Illuminate\Http\Request;


Route::get('/', function () {
    return view('home');
});



Route::post('/history', function (Request $request) {
    $validated = $request->validate([
        'city' => 'required|string|max:255',
        'zipcode' => 'nullable|string|max:8',
        'temperature' => 'required|numeric',
        'description' => 'required|string|max:255',
    ]);

    WeatherHistory::create($validated);

    return response()->json(['message' => 'Histórico salvo com sucesso!']);
});


Route::get('/history', function () {
    $histories = WeatherHistory::orderBy('created_at', 'desc')->paginate(10);
    return view('history', ['histories' => $histories]);
});



