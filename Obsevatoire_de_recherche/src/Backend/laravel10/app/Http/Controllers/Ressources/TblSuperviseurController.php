<?php

namespace App\Http\Controllers\Ressources;

use App\Http\Controllers\Controller;
use App\Models\TblSuperviseur;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TblSuperviseurController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $superviseur = TblSuperviseur::all();
        return response()->json($superviseur);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nom_sup'=>'required|unique:tbl_superviseurs,nom_sup|max:255',
            'email_sup'=>'required|unique:tbl_superviseurs,email_sup|max:255'

        ]);
        if($validator->fails()){
            return response()->json(['errors' => $validator->errors()], 400);
        }

        $superviseur = TblSuperviseur::create([
            'nom_sup' => $request->nom_sup,
            "email_sup"=>$request->email_sup,

        ]);
        return response()->json($superviseur);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $superviseur = TblSuperviseur::where('id', $id)->firstOrFail();
        return response()->json($superviseur);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validator = Validator::make($request->all(), [
            'nom_sup'=>'required|max:255',
            'email_sup'=>'required|email|max:255',
        ]);
        if($validator->fails()){
            return response()->json(['errors' => $validator->errors()], 400);
        }

        $superviseur = TblSuperviseur::where('id', $id)->firstOrFail();
        $superviseur->nom_sup = $request->nom_sup;
        $superviseur->email_sup = $request->email_sup;

        $superviseur->save();

        return response()->json($superviseur);

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        TblSuperviseur::where('id', $id)->delete();
        return response()->noContent();
    }
}
