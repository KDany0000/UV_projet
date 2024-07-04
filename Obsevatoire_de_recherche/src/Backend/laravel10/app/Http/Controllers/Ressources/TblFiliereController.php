<?php

namespace App\Http\Controllers\Ressources;

use App\Http\Controllers\Controller;
use App\Models\TblFiliere;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TblFiliereController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/ressources/filieres",
     *     summary="Get list of all filieres",
     *     tags={"Filieres"},
     *     @OA\Response(
     *         response=200,
     *         description="A list of filieres",
     *         @OA\JsonContent(type="array", @OA\Items(ref="#/components/schemas/TblFiliere"))
     *     )
     * )
     */
    public function index()
    {
        $filiere = TblFiliere::all();
        return response()->json($filiere);
    }

    /**
     * @OA\Post(
     *     path="/api/ressources/filieres",
     *     summary="Create a new filiere",
     *     tags={"Filieres"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/TblFiliere")
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Filiere created",
     *         @OA\JsonContent(ref="#/components/schemas/TblFiliere")
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
            'nom_fil' => 'required|unique:tbl_filieres,nom_fil|max:255',
            'tbl_faculte_id' => 'required|exists:tbl_facultes,id'
        ]);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }

        $filiere = TblFiliere::create([
            'nom_fil' => $request->nom_fil,
            'tbl_faculte_id' => $request->tbl_faculte_id,
        ]);
        return response()->json($filiere);
    }

    /**
     * @OA\Get(
     *     path="/api/ressources/filieres/{id}",
     *     summary="Get a filiere by ID",
     *     tags={"Filieres"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Filiere details",
     *         @OA\JsonContent(ref="#/components/schemas/TblFiliere")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Filiere not found"
     *     )
     * )
     */
    public function show(string $id)
    {
        $filiere = TblFiliere::where('id', $id)->firstOrFail();
        return response()->json($filiere);
    }

    /**
     * @OA\Put(
     *     path="/api/ressources/filieres/{id}",
     *     summary="Update a filiere",
     *     tags={"Filieres"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/TblFiliere")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Filiere updated",
     *         @OA\JsonContent(ref="#/components/schemas/TblFiliere")
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Validation error"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Filiere not found"
     *     )
     * )
     */
    public function update(Request $request, string $id)
    {
        $validator = Validator::make($request->all(), [
            'nom_fil' => 'required|max:255',
            'tbl_faculte_id' => 'required|exists:tbl_facultes,id',
        ]);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }

        $filiere = TblFiliere::where('id', $id)->firstOrFail();
        $filiere->nom_fil = $request->nom_fil;
        $filiere->tbl_faculte_id = $request->tbl_faculte_id;

        $filiere->save();

        return response()->json($filiere);
    }

    /**
     * @OA\Delete(
     *     path="/api/ressources/filieres/{id}",
     *     summary="Delete a filiere",
     *     tags={"Filieres"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(
     *         response=204,
     *         description="Filiere deleted"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Filiere not found"
     *     )
     * )
     */
    public function destroy(string $id)
    {
        TblFiliere::where('id', $id)->delete();
        return response()->noContent();
    }
}
