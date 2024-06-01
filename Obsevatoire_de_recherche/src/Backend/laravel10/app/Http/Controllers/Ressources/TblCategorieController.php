<?php

namespace App\Http\Controllers\Ressources;

use App\Http\Controllers\Controller;
use App\Models\TblCategorie;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TblCategorieController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categorie = TblCategorie::all();
        return response()->json($categorie);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nom_cat'=>'required|unique:tbl_categories,nom_cat|max:255',
            'descript_cat'=>'required|unique:tbl_categories,descript_cat|max:255'
        ]);
        if($validator->fails()){
            return response()->json(['errors' => $validator->errors()], 400);
        }

        $categorie = TblCategorie::create([
            'nom_cat' => $request->nom_cat,
            "descript_cat"=>$request->descript_cat,

        ]);
        return response()->json($categorie);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $categorie = TblCategorie::where('id', $id)->firstOrFail();
        return response()->json($categorie);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validator = Validator::make($request->all(), [
            'nom_cat'=>'required|max:255',
            'descript_cat'=>'required',
        ]);
        if($validator->fails()){
            return response()->json(['errors' => $validator->errors()], 400);
        }

        $categorie = TblCategorie::where('id', $id)->firstOrFail();
        $categorie->nom_cat = $request->nom_cat;
        $categorie->descript_cat = $request->descript_cat;

        $categorie->save();

        return response()->json($categorie);

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        TblCategorie::where('id', $id)->delete();
        return response()->noContent();
    }
}
