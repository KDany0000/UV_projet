<?php

namespace App\Http\Controllers\Ressources;

use App\Http\Controllers\Controller;
use App\Models\TblFaculte;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use function Laravel\Prompts\error;

class TblFaculteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $faculte = TblFaculte::all();
        return response()->json($faculte);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nom_fac'=>'required|unique:tbl_facultes,nom_fac|max:255',
            'email_fac'=>'required|email|unique:tbl_facultes,nom_fac|max:255',
            'tbl_universite_id'=>'required|exists:tbl_universites,id'
        ]);
        if($validator->fails()){
            return response()->json(['errors' => $validator->errors()], 400);
        }

        $faculte = TblFaculte::create([
            'nom_fac' => $request->nom_fac,
            'email_fac' => $request->email_fac,
            "tbl_universite_id"=>$request->tbl_universite_id,

        ]);
        return response()->json($faculte);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $faculte = TblFaculte::where('id', $id)->firstOrFail();
        return response()->json($faculte);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validator = Validator::make($request->all(), [
            'nom_fac'=>'required|max:255',
            'email_fac'=>'required|email|max:255',
            'tbl_universite_id'=>'required|exists:tbl_universites,id',
        ]);
        if($validator->fails()){
            return response()->json(['errors' => $validator->errors()], 400);
        }

        $faculte = TblFaculte::where('id', $id)->firstOrFail();
        $faculte->nom_fac = $request->nom_fac;
        $faculte->email_fac = $request->email_fac;
        $faculte->tbl_universite_id = $request->tbl_universite_id;

        $faculte->save();

        return response()->json($faculte);

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        TblFaculte::where('id', $id)->delete();
        return response()->noContent();
    }
}
