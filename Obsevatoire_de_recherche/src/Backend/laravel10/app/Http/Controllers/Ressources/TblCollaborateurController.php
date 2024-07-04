<?php

namespace App\Http\Controllers\Ressources;

use App\Http\Controllers\Controller;
use App\Models\TblCollaborateur;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TblCollaborateurController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/ressources/collaborateurs",
     *     summary="Get list of all collaborators",
     *     tags={"Collaborators"},
     *     @OA\Response(
     *         response=200,
     *         description="A list of collaborators",
     *         @OA\JsonContent(type="array", @OA\Items(ref="#/components/schemas/TblCollaborateur"))
     *     )
     * )
     */
    public function index()
    {
        $collaborateur = TblCollaborateur::all();
        return response()->json($collaborateur);
    }

    /**
     * @OA\Post(
     *     path="/api/ressources/collaborateurs",
     *     summary="Create a new collaborator",
     *     tags={"Collaborators"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/TblCollaborateur")
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Collaborator created",
     *         @OA\JsonContent(ref="#/components/schemas/TblCollaborateur")
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
            'nom_collab'=>'required|unique:tbl_collaborateurs,nom_collab|max:255',
            'email_collab'=>'required|unique:tbl_collaborateurs,email_collab|max:255'
        ]);
        if($validator->fails()){
            return response()->json(['errors' => $validator->errors()], 400);
        }

        $collaborateur = TblCollaborateur::create([
            'nom_collab' => $request->nom_collab,
            "email_collab" => $request->email_collab,
        ]);
        return response()->json($collaborateur, 201);
    }

    /**
     * @OA\Get(
     *     path="/api/ressources/collaborateurs/{id}",
     *     summary="Get a collaborator by ID",
     *     tags={"Collaborators"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Collaborator details",
     *         @OA\JsonContent(ref="#/components/schemas/TblCollaborateur")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Collaborator not found"
     *     )
     * )
     */
    public function show(string $id)
    {
        $collaborateur = TblCollaborateur::where('id', $id)->firstOrFail();
        return response()->json($collaborateur);
    }

    /**
     * @OA\Put(
     *     path="/api/ressources/collaborateurs/{id}",
     *     summary="Update a collaborator",
     *     tags={"Collaborators"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/TblCollaborateur")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Collaborator updated",
     *         @OA\JsonContent(ref="#/components/schemas/TblCollaborateur")
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Validation error"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Collaborator not found"
     *     )
     * )
     */
    public function update(Request $request, string $id)
    {
        $validator = Validator::make($request->all(), [
            'nom_collab' => 'required|max:255',
            'email_collab' => 'required|email|max:255',
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
     * @OA\Delete(
     *     path="/api/ressources/collaborateurs/{id}",
     *     summary="Delete a collaborator",
     *     tags={"Collaborators"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(
     *         response=204,
     *         description="Collaborator deleted"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Collaborator not found"
     *     )
     * )
     */
    public function destroy(string $id)
    {
        TblCollaborateur::where('id', $id)->delete();
        return response()->noContent();
    }
}
