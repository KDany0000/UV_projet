<?php

namespace App\Http\Controllers\Ressources;

use App\Http\Controllers\Controller;
use App\Models\TblUniversite;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TblUniversiteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $universite = TblUniversite::all();
        return response()->json($universite);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nom_univ' => 'required|unique:tbl_universites,nom_univ|max:255',
            'localite_univ' => 'required|max:255',
            'email_univ' => 'required|email|unique:tbl_universites,email_univ|max:255',
            'boite_postale' => 'required|string|min:3|unique:tbl_universites,boite_postale',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }

        $universite = TblUniversite::create([
            'nom_univ' => $request->nom_univ,
            'email_univ' => $request->email_univ,
            'localite_univ' => $request->localite_univ,
            'boite_postale' => $request->boite_postale,
        ]);

        return response()->json($universite, 201);
    }


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $universite = TblUniversite::where('id' ,$id )->firstOrFail();
        return response()->json($universite);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validator = Validator::make($request->all(), [
            'nom_univ' => 'required|max:255',
            'localite_univ' => 'required|max:255',
            'email_univ' => 'required|email|max:255',
            'boite_postale' => 'required|string|min:3',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }

        $universite = TblUniversite::where('id',$id)->firstOrFail();
        $universite->nom_univ = $request->nom_univ;
        $universite->localite_univ = $request->localite_univ;
        $universite->email_univ = $request->email_univ;
        $universite->boite_postale = $request->boite_postale;
        $universite->save();

        return response()->json($universite);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(String $id)
    {
        TblUniversite::where('id', $id)->delete();
        return response()->noContent();
    }
}
