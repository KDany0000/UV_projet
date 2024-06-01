<?php

namespace App\Http\Controllers\Ressources;

use App\Http\Controllers\Controller;
use App\Models\TblProjet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TblProjetController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $projet = TblProjet::all();
        return response()->json($projet);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'titre_projet' => 'required|unique:tbl_projets,titre_projet|max:255',
            'descript_projet' => 'required|max:255',
            'tbl_niveau_id' => 'required|exists:tbl_niveaux,id',
            'user_id' => 'required|exists:users,id',
            'tbl_categorie_id' => 'required|exists:tbl_categories,id',

        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }

        $projet = TblProjet::create([
            'titre_projet' => $request->titre_projet,
            'descript_projet' => $request->descript_projet,
            'tbl_niveau_id' => $request->tbl_niveau_id,
            'user_id' => $request->user_id,
            'tbl_categorie_id' => $request->tbl_categorie_id,
        ]);

        return response()->json($projet, 201);
    }


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $projet = TblProjet::where('id' ,$id )->firstOrFail();
        return response()->json($projet);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validator = Validator::make($request->all(), [
            'titre_projet' => 'required|max:255',
            'descript_projet' => 'required|max:255',
            'tbl_niveau_id' => 'required',
            'user_id' => 'required',
            'tbl_categorie_id' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }

        $projet = TblProjet::where('id',$id)->firstOrFail();
        $projet->titre_projet = $request->titre_projet;
        $projet->descript_projet = $request->descript_projet;
        $projet->tbl_niveau_id = $request->tbl_niveau_id;
        $projet->user_id = $request->user_id;
        $projet->tbl_categorie_id = $request->tbl_categorie_id;
        $projet->save();

        return response()->json($projet);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(String $id)
    {
        TblProjet::where('id', $id)->delete();
        return response()->noContent();
    }
}
