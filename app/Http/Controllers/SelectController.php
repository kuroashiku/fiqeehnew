<?php

namespace App\Http\Controllers;

use App\Category;
use Illuminate\Http\Request;

class KecamatanDropdownController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        //
        $provinsi = Category::findOrFail($request->id);
        $kotaFiltered = $provinsi->category->pluck('nama', 'id');
        return response()->json($kotaFiltered);

    }
}