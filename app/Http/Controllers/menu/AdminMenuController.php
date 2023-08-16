<?php

namespace App\Http\Controllers\menu;

use App\Http\Controllers\Controller;
use App\Models\Menu;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Validator;

class AdminMenuController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();
        if($user) {
            $menus = Menu::all();
            return response()->json(['menus' => $menus],200);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
         Auth::user();
        
        $validateMenu = Validator::make($request->all(), [
            'name' => 'required|string',
            'img' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048', // Adjust validation rules
            'price' => 'required|integer',
            'category' => 'required|string',
        ]);
    
        if ($validateMenu->fails()) {
            return response()->json(['error' => $validateMenu->errors()], 400);
        }
    
        if ($request->hasFile('img') && $request->file('img')->isValid()) {
            $file = $request->file('img');
            $filename = time() . '_' . $file->getClientOriginalName();
    
            $file->storeAs('menus', $filename, 'public');
    
            $menu = new Menu();
            $menu->name = $request->name;
            $menu->img = asset('storage/menus/' . $filename); // Make sure the asset path is correct
            $menu->price = $request->price;
            $menu->category = $request->category;
            $menu->save();
    
            return response()->json(['success' => 'Menu created Successfully', 'menu' => $menu], 201);
        } else {
            return response()->json(['error' => 'Invalid image file'], 400);
        }
    }
    

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    /**
 * Update the specified resource in storage.
 */
public function update(Request $request, string $id)
{
    $menu = Menu::find($id);

    if (!$menu) {
        return response()->json(['error' => 'Menu not found'], 404);
    }

    // Validate the updated data
    $validateMenu = Validator::make($request->all(), [
        'name' => 'required|string',
        'img' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Adjust validation rules
        'price' => 'required|integer',
        'category' => 'required|string',
    ]);

    if ($validateMenu->fails()) {
        return response()->json(['error' => $validateMenu->errors()], 400);
    }

    // Update the menu properties
    $menu->name = $request->name;
    $menu->price = $request->price;
    $menu->category = $request->category;

    if ($request->hasFile('img') && $request->file('img')->isValid()) {
        $file = $request->file('img');
        $filename = time() . '_' . $file->getClientOriginalName();

        // Remove the old image if it exists
        if ($menu->img) {
            Storage::disk('public')->delete('menus/' . basename($menu->img));
        }

        $file->storeAs('menus', $filename, 'public');
        $menu->img = asset('storage/menus/' . $filename);
    }

    $menu->save();

    return response()->json(['success' => 'Menu updated Successfully', 'menu' => $menu], 200);
}


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $menu = Menu::find($id);

        if (!$menu) {
            return response()->json(['error' => 'Menu not found'], 404);
        }

        if ($menu->img) {
            Storage::disk('public')->delete('menus/'. basename($menu->img));
        }

        $menu->delete();

        return response()->json(['success' => 'Menu deleted Successfully'], 200);
    }
}
