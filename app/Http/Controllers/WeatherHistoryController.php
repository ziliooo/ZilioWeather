<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\WeatherHistory;

class WeatherHistoryController extends Controller
{
    public function index()
    {
        $histories = WeatherHistory::orderBy('created_at', 'desc')->get();
        return view('history', compact('histories'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'city' => 'required|string',
            'zipcode' => 'nullable|string',
            'temperature' => 'required|string',
            'description' => 'required|string',
        ]);

        WeatherHistory::create($data);

        return response()->json(['message' => 'Histórico salvo com sucesso!'], 201);
    }
}
