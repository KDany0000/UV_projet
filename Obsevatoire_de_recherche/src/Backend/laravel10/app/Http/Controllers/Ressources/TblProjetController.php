<?php

namespace App\Http\Controllers\Ressources;

use App\Http\Controllers\Controller;
use App\Models\TblProjet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TblProjetController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/ressources/projets",
     *     summary="Get list of all projets",
     *     tags={"Projets"},
     *     @OA\Response(
     *         response=200,
     *         description="A list of projets",
     *         @OA\JsonContent(type="array", @OA\Items(ref="#/components/schemas/TblProjet"))
     *     )
     * )
     */
    public function index()
    {
        $projet = TblProjet::all();
        return response()->json($projet);
    }

    /**
     * @OA\Post(
     *     path="/api/ressources/projets",
     *     summary="Create a new projet",
     *     tags={"Projets"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/TblProjet")
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Projet created",
     *         @OA\JsonContent(ref="#/components/schemas/TblProjet")
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
     * @OA\Get(
     *     path="/api/ressources/projets/{id}",
     *     summary="Get a projet by ID",
     *     tags={"Projets"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Projet details",
     *         @OA\JsonContent(ref="#/components/schemas/TblProjet")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Projet not found"
     *     )
     * )
     */
    public function show(string $id)
    {
        $projet = TblProjet::where('id', $id)->firstOrFail();
        return response()->json($projet);
    }

    /**
     * @OA\Put(
     *     path="/api/ressources/projets/{id}",
     *     summary="Update a projet",
     *     tags={"Projets"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/TblProjet")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Projet updated",
     *         @OA\JsonContent(ref="#/components/schemas/TblProjet")
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Validation error"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Projet not found"
     *     )
     * )
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

        $projet = TblProjet::where('id', $id)->firstOrFail();
        $projet->titre_projet = $request->titre_projet;
        $projet->descript_projet = $request->descript_projet;
        $projet->tbl_niveau_id = $request->tbl_niveau_id;
        $projet->user_id = $request->user_id;
        $projet->tbl_categorie_id = $request->tbl_categorie_id;
        $projet->save();

        return response()->json($projet);
    }

    /**
     * @OA\Delete(
     *     path="/api/ressources/projets/{id}",
     *     summary="Delete a projet",
     *     tags={"Projets"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(
     *         response=204,
     *         description="Projet deleted"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Projet not found"
     *     )
     * )
     */
    public function destroy(string $id)
    {
        TblProjet::where('id', $id)->delete();
        return response()->noContent();
    }
}
