<?php

namespace App\Http\Controllers\Ressources;

use App\Http\Controllers\Controller;
use App\Models\TblUniversite;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TblUniversiteController extends Controller
{
    /**
     * @OA\Get(
     *     path="api/ressources/universites",
     *     summary="Get list of all universites",
     *     tags={"Universites"},
     *     @OA\Response(
     *         response=200,
     *         description="A list of universites",
     *         @OA\JsonContent(type="array", @OA\Items(ref="#/components/schemas/TblUniversite"))
     *     )
     * )
     */
    public function index()
    {
        $universite = TblUniversite::all();
        return response()->json($universite);
    }

    /**
     * @OA\Post(
     *     path="/api/ressources/universites",
     *     summary="Create a new universite",
     *     tags={"Universites"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/TblUniversite")
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Universite created",
     *         @OA\JsonContent(ref="#/components/schemas/TblUniversite")
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
            'nom_univ' => 'required|unique:tbl_universites,nom_univ|max:255',
            'localite_univ' => 'required|max:255',
            'email_univ' => 'required|email|unique:tbl_universites,email_univ|max:255',
            'boite_postale' => 'required|string|min:3|unique:tbl_universites,boite_postale',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }

        $universite = TblUniversite::create([
            'nom_univ' => $request->nom_univ,
            'email_univ' => $request->email_univ,
            'localite_univ' => $request->localite_univ,
            'boite_postale' => $request->boite_postale,
        ]);

        return response()->json($universite, 201);
    }

    /**
     * @OA\Get(
     *     path="api/ressources/universites/{id}",
     *     summary="Get a universite by ID",
     *     tags={"Universites"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Universite details",
     *         @OA\JsonContent(ref="#/components/schemas/TblUniversite")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Universite not found"
     *     )
     * )
     */
    public function show(string $id)
    {
        $universite = TblUniversite::where('id', $id)->firstOrFail();
        return response()->json($universite);
    }

    /**
     * @OA\Put(
     *     path="api/ressources/universites/{id}",
     *     summary="Update a universite",
     *     tags={"Universites"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/TblUniversite")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Universite updated",
     *         @OA\JsonContent(ref="#/components/schemas/TblUniversite")
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Validation error"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Universite not found"
     *     )
     * )
     */
    public function update(Request $request, string $id)
    {
        $validator = Validator::make($request->all(), [
            'nom_univ' => 'required|max:255',
            'localite_univ' => 'required|max:255',
            'email_univ' => 'required|email|max:255',
            'boite_postale' => 'required|string|min:3',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }

        $universite = TblUniversite::where('id', $id)->firstOrFail();
        $universite->nom_univ = $request->nom_univ;
        $universite->localite_univ = $request->localite_univ;
        $universite->email_univ = $request->email_univ;
        $universite->boite_postale = $request->boite_postale;
        $universite->save();

        return response()->json($universite);
    }

    /**
     * @OA\Delete(
     *     path="api/ressources/universites/{id}",
     *     summary="Delete a universite",
     *     tags={"Universites"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(
     *         response=204,
     *         description="Universite deleted"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Universite not found"
     *     )
     * )
     */
    public function destroy(string $id)
    {
        TblUniversite::where('id', $id)->delete();
        return response()->noContent();
    }
}
