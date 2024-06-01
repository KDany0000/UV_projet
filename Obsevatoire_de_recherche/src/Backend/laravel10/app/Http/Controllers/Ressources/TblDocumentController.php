<?php

namespace App\Http\Controllers\Ressources;

use App\Http\Controllers\Controller;
use App\Models\TblDocument;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
class TblDocumentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $document = TblDocument::all();
        return response()->json($document);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nom_doc' => 'required|unique:tbl_documents,nom_doc|max:255',
            'lien_doc' => 'required|unique:tbl_documents,lien_doc|max:255',
            'type_doc' => ['required', 'in:PDF,WORD,POWEPOINT'],
            'resume' => 'required',
            'tbl_projet_id' => 'required|exists:tbl_projets,id',

        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }

        $document = TblDocument::create([
            'nom_doc' => $request->nom_doc,
            'lien_doc' => $request->lien_doc,
            'type_doc' => $request->type_doc,
            'resume' => $request->resume,
            'tbl_projet_id' => $request->tbl_projet_id,
        ]);

        return response()->json($document, 201);
    }


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $document = TblDocument::where('id' ,$id )->firstOrFail();
        return response()->json($document);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validator = Validator::make($request->all(), [
            'nom_doc' => 'required|max:255',
            'lien_doc' => 'required|max:255',
            'type_doc' => 'required',
            'resume' => 'required',
            'tbl_projet_id' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }

        $document = TblDocument::where('id',$id)->firstOrFail();
        $document->nom_doc = $request->nom_doc;
        $document->lien_doc = $request->lien_doc;
        $document->type_doc = $request->type_doc;
        $document->resume = $request->resume;
        $document->tbl_projet_id = $request->tbl_projet_id;
        $document->save();

        return response()->json($document);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(String $id)
    {
        TblDocument::where('id', $id)->delete();
        return response()->noContent();
    }
}
