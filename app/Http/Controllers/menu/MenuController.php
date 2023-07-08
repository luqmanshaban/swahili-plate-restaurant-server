<?php

namespace App\Http\Controllers\menu;

use App\Http\Controllers\Controller;
use App\Models\Menu;
use Illuminate\Http\Request;

class MenuController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function topPick()
    {
        $featuredMenu = Menu::where('category', 'topPick')->get();
        if($featuredMenu->count() === 0) {
            return response()->json(['message' => 'MENU NOT FOUND'], 404);
        }
        return response()->json(['topPick' => $featuredMenu], 200);
    }

    public function meals() {
        $meals = Menu::where('category', 'meals')->get();
        if($meals->count() === 0) {
            return response()->json(['message' => 'MENU NOT FOUND'], 404);
        }
        return response()->json(['meals' => $meals], 200);
    }

    public function drinks() {
        $drinks = Menu::where('category', 'drinks')->get();
        if($drinks->count() === 0) {
            return response()->json(['message' => 'MENU NOT FOUND'],404);
        }
        return response()->json(['drinks' => $drinks], 200);
    }

    public function shawarma() {
        $shawarma = Menu::where('category', 'shawarma')->get();
        if($shawarma->count() === 0) {
            return response()->json(['message' => 'MENU NOT FOUND'],404);
        }
        return response()->json(['shawarma' => $shawarma], 200);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
