<?php

namespace App\Http\Controllers\Ressources;

use App\Http\Controllers\Controller;
use App\Models\TblCollaborateur;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


class TblCollaborateurController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $collaborateur = TblCollaborateur::all();
        return response()->json($collaborateur);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nom_collab'=>'required|unique:tbl_collaborateurs,nom_collab|max:255',
            'email_collab'=>'required|unique:tbl_collaborateurs,email_collab|max:255'

        ]);
        if($validator->fails()){
            return response()->json(['errors' => $validator->errors()], 400);
        }

        $collaborateur = TblCollaborateur::create([
            'nom_collab' => $request->nom_collab,
            "email_collab"=>$request->email_collab,

        ]);
        return response()->json($collaborateur);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $collaborateur = TblCollaborateur::where('id', $id)->firstOrFail();
        return response()->json($collaborateur);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validator = Validator::make($request->all(), [
            'nom_collab'=>'required|max:255',
            'email_collab'=>'required|email|max:255',
        ]);
        if($validator->fails()){
            return response()->json(['errors' => $validator->errors()], 400);
        }

        $collaborateur = TblCollaborateur::where('id', $id)->firstOrFail();
        $collaborateur->nom_collab = $request->nom_collab;
        $collaborateur->email_collab = $request->email_collab;

        $collaborateur->save();

        return response()->json($collaborateur);

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        TblCollaborateur::where('id', $id)->delete();
        return response()->noContent();
    }
}
