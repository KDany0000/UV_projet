<?php

namespace App\Http\Controllers\Ressources;

use App\Http\Controllers\Controller;
use App\Models\TblNiveau;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TblNiveauController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/ressources/niveaux",
     *     summary="Get list of all niveaux",
     *     tags={"Niveaux"},
     *     @OA\Response(
     *         response=200,
     *         description="A list of niveaux",
     *         @OA\JsonContent(type="array", @OA\Items(ref="#/components/schemas/TblNiveau"))
     *     )
     * )
     */
    public function index()
    {
        $niveau = TblNiveau::all();
        return response()->json($niveau);
    }

    /**
     * @OA\Post(
     *     path="/api/ressources/niveaux",
     *     summary="Create a new niveau",
     *     tags={"Niveaux"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/TblNiveau")
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Niveau created",
     *         @OA\JsonContent(ref="#/components/schemas/TblNiveau")
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
            'code_niv' => 'required|unique:tbl_niveaux,code_niv|max:255',
        ]);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }

        $niveau = TblNiveau::create([
            'code_niv' => $request->code_niv,
        ]);
        return response()->json($niveau);
    }

    /**
     * @OA\Get(
     *     path="/api/ressources/niveaux/{id}",
     *     summary="Get a niveau by ID",
     *     tags={"Niveaux"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Niveau details",
     *         @OA\JsonContent(ref="#/components/schemas/TblNiveau")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Niveau not found"
     *     )
     * )
     */
    public function show(string $id)
    {
        $niveau = TblNiveau::where('id', $id)->firstOrFail();
        return response()->json($niveau);
    }

    /**
     * @OA\Put(
     *     path="/api/ressources/niveaux/{id}",
     *     summary="Update a niveau",
     *     tags={"Niveaux"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/TblNiveau")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Niveau updated",
     *         @OA\JsonContent(ref="#/components/schemas/TblNiveau")
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Validation error"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Niveau not found"
     *     )
     * )
     */
    public function update(Request $request, string $id)
    {
        $validator = Validator::make($request->all(), [
            'code_niv' => 'required|max:255',
        ]);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }

        $niveau = TblNiveau::where('id', $id)->firstOrFail();
        $niveau->code_niv = $request->code_niv;

        $niveau->save();

        return response()->json($niveau);
    }

    /**
     * @OA\Delete(
     *     path="/api/ressources/niveaux/{id}",
     *     summary="Delete a niveau",
     *     tags={"Niveaux"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(
     *         response=204,
     *         description="Niveau deleted"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Niveau not found"
     *     )
     * )
     */
    public function destroy(string $id)
    {
        TblNiveau::where('id', $id)->delete();
        return response()->noContent();
    }
}
