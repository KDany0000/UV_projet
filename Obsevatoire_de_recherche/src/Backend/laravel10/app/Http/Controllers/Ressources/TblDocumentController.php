<?php

namespace App\Http\Controllers\Ressources;

use App\Http\Controllers\Controller;
use App\Models\TblDocument;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TblDocumentController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/ressources/documents",
     *     summary="Get list of all documents",
     *     tags={"Documents"},
     *     @OA\Response(
     *         response=200,
     *         description="A list of documents",
     *         @OA\JsonContent(type="array", @OA\Items(ref="#/components/schemas/TblDocument"))
     *     )
     * )
     */
    public function index()
    {
        $document = TblDocument::all();
        return response()->json($document);
    }

    /**
     * @OA\Post(
     *     path="/api/ressources/documents",
     *     summary="Create a new document",
     *     tags={"Documents"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/TblDocument")
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Document created",
     *         @OA\JsonContent(ref="#/components/schemas/TblDocument")
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Validation error"
     *     )
     * )
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
     * @OA\Get(
     *     path="/api/ressources/documents/{id}",
     *     summary="Get a document by ID",
     *     tags={"Documents"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Document details",
     *         @OA\JsonContent(ref="#/components/schemas/TblDocument")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Document not found"
     *     )
     * )
     */
    public function show(string $id)
    {
        $document = TblDocument::where('id', $id)->firstOrFail();
        return response()->json($document);
    }

    /**
     * @OA\Put(
     *     path="/api/ressources/documents/{id}",
     *     summary="Update a document",
     *     tags={"Documents"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/TblDocument")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Document updated",
     *         @OA\JsonContent(ref="#/components/schemas/TblDocument")
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Validation error"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Document not found"
     *     )
     * )
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

        $document = TblDocument::where('id', $id)->firstOrFail();
        $document->nom_doc = $request->nom_doc;
        $document->lien_doc = $request->lien_doc;
        $document->type_doc = $request->type_doc;
        $document->resume = $request->resume;
        $document->tbl_projet_id = $request->tbl_projet_id;
        $document->save();

        return response()->json($document);
    }

    /**
     * @OA\Delete(
     *     path="/api/ressources/documents/{id}",
     *     summary="Delete a document",
     *     tags={"Documents"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(
     *         response=204,
     *         description="Document deleted"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Document not found"
     *     )
     * )
     */
    public function destroy(string $id)
    {
        TblDocument::where('id', $id)->delete();
        return response()->noContent();
    }
}
