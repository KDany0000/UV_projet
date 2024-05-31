<?php

namespace App\Http\Controllers\Ressources;

use App\Http\Controllers\Controller;
use App\Models\TblFiliere;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TblFiliereController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $filiere = TblFiliere::all();
        return response()->json($filiere);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nom_fil'=>'required|unique:tbl_filieres,nom_fil|max:255',
            'tbl_faculte_id'=>'required|exists:tbl_facultes,id'
        ]);
        if($validator->fails()){
            return response()->json(['errors' => $validator->errors()], 400);
        }

        $filiere = TblFiliere::create([
            'nom_fil' => $request->nom_fil,
            "tbl_faculte_id"=>$request->tbl_faculte_id,

        ]);
        return response()->json($filiere);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $filiere = TblFiliere::where('id', $id)->firstOrFail();
        return response()->json($filiere);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validator = Validator::make($request->all(), [
            'nom_fil'=>'required|max:255',
            'tbl_faculte_id'=>'required|exists:tbl_facultes,id',
        ]);
        if($validator->fails()){
            return response()->json(['errors' => $validator->errors()], 400);
        }

        $filiere = TblFiliere::where('id', $id)->firstOrFail();
        $filiere->nom_fil = $request->nom_fil;
        $filiere->tbl_faculte_id = $request->tbl_faculte_id;

        $filiere->save();

        return response()->json($filiere);

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        TblFiliere::where('id', $id)->delete();
        return response()->noContent();
    }
}
