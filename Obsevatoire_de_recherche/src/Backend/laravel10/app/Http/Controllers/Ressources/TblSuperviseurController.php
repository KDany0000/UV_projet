<?php

namespace App\Http\Controllers\Ressources;

use App\Http\Controllers\Controller;
use App\Models\TblSuperviseur;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TblSuperviseurController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/ressources/superviseurs",
     *     summary="Get list of all superviseurs",
     *     tags={"Superviseurs"},
     *     @OA\Response(
     *         response=200,
     *         description="A list of superviseurs",
     *         @OA\JsonContent(type="array", @OA\Items(ref="#/components/schemas/TblSuperviseur"))
     *     )
     * )
     */
    public function index()
    {
        $superviseur = TblSuperviseur::all();
        return response()->json($superviseur);
    }

    /**
     * @OA\Post(
     *     path="/api/ressources/superviseurs",
     *     summary="Create a new superviseur",
     *     tags={"Superviseurs"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/TblSuperviseur")
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Superviseur created",
     *         @OA\JsonContent(ref="#/components/schemas/TblSuperviseur")
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
            'nom_sup'=>'required|unique:tbl_superviseurs,nom_sup|max:255',
            'email_sup'=>'required|unique:tbl_superviseurs,email_sup|max:255'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }

        $superviseur = TblSuperviseur::create([
            'nom_sup' => $request->nom_sup,
            'email_sup' => $request->email_sup,
        ]);

        return response()->json($superviseur, 201);
    }

    /**
     * @OA\Get(
     *     path="/api/ressources/superviseurs/{id}",
     *     summary="Get a superviseur by ID",
     *     tags={"Superviseurs"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Superviseur details",
     *         @OA\JsonContent(ref="#/components/schemas/TblSuperviseur")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Superviseur not found"
     *     )
     * )
     */
    public function show(string $id)
    {
        $superviseur = TblSuperviseur::where('id', $id)->firstOrFail();
        return response()->json($superviseur);
    }

    /**
     * @OA\Put(
     *     path="/api/ressources/superviseurs/{id}",
     *     summary="Update a superviseur",
     *     tags={"Superviseurs"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/TblSuperviseur")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Superviseur updated",
     *         @OA\JsonContent(ref="#/components/schemas/TblSuperviseur")
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Validation error"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Superviseur not found"
     *     )
     * )
     */
    public function update(Request $request, string $id)
    {
        $validator = Validator::make($request->all(), [
            'nom_sup'=>'required|max:255',
            'email_sup'=>'required|email|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }

        $superviseur = TblSuperviseur::where('id', $id)->firstOrFail();
        $superviseur->nom_sup = $request->nom_sup;
        $superviseur->email_sup = $request->email_sup;

        $superviseur->save();

        return response()->json($superviseur);
    }

    /**
     * @OA\Delete(
     *     path="/api/ressources/superviseurs/{id}",
     *     summary="Delete a superviseur",
     *     tags={"Superviseurs"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(
     *         response=204,
     *         description="Superviseur deleted"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Superviseur not found"
     *     )
     * )
     */
    public function destroy(string $id)
    {
        TblSuperviseur::where('id', $id)->delete();
        return response()->noContent();
    }
}
