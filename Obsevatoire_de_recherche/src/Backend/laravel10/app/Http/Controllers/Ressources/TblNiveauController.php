<?php

namespace App\Http\Controllers\Ressources;

use App\Http\Controllers\Controller;
use App\Models\TblNiveau;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TblNiveauController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $niveau = TblNiveau::all();
        return response()->json($niveau);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'code_niveau'=>'required|unique:tbl_niveaux,nom_fil|max:255',
        ]);
        if($validator->fails()){
            return response()->json(['errors' => $validator->errors()], 400);
        }

        $niveau = TblNiveau::create([
            'code_niveau' => $request->code_niveau,

        ]);
        return response()->json($niveau);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $niveau = TblNiveau::where('id', $id)->firstOrFail();
        return response()->json($niveau);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validator = Validator::make($request->all(), [
            'code_niveau'=>'required|max:255',
        ]);
        if($validator->fails()){
            return response()->json(['errors' => $validator->errors()], 400);
        }

        $niveau = TblNiveau::where('id', $id)->firstOrFail();
        $niveau->nom_fil = $request->nom_fil;
        $niveau->tbl_faculte_id = $request->tbl_faculte_id;

        $niveau->save();

        return response()->json($niveau);

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        TblNiveau::where('id', $id)->delete();
        return response()->noContent();
    }
}
