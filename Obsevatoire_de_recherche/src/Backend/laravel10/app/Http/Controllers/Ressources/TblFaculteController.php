<?php

namespace App\Http\Controllers\Ressources;

use App\Http\Controllers\Controller;
use App\Models\TblFaculte;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TblFaculteController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/ressources/facultes",
     *     summary="Get list of all faculties",
     *     tags={"Faculties"},
     *     @OA\Response(
     *         response=200,
     *         description="A list of faculties",
     *         @OA\JsonContent(type="array", @OA\Items(ref="#/components/schemas/TblFaculte"))
     *     )
     * )
     */
    public function index()
    {
        $faculte = TblFaculte::all();
        return response()->json($faculte);
    }

    /**
     * @OA\Post(
     *     path="/api/ressources/facultes",
     *     summary="Create a new faculty",
     *     tags={"Faculties"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/TblFaculte")
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Faculty created",
     *         @OA\JsonContent(ref="#/components/schemas/TblFaculte")
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
     * @OA\Get(
     *     path="/api/ressources/facultes/{id}",
     *     summary="Get a faculty by ID",
     *     tags={"Faculties"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Faculty details",
     *         @OA\JsonContent(ref="#/components/schemas/TblFaculte")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Faculty not found"
     *     )
     * )
     */
    public function show(string $id)
    {
        $faculte = TblFaculte::where('id', $id)->firstOrFail();
        return response()->json($faculte);
    }

    /**
     * @OA\Put(
     *     path="/api/ressources/facultes/{id}",
     *     summary="Update a faculty",
     *     tags={"Faculties"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/TblFaculte")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Faculty updated",
     *         @OA\JsonContent(ref="#/components/schemas/TblFaculte")
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Validation error"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Faculty not found"
     *     )
     * )
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
     * @OA\Delete(
     *     path="/api/ressources/facultes/{id}",
     *     summary="Delete a faculty",
     *     tags={"Faculties"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(
     *         response=204,
     *         description="Faculty deleted"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Faculty not found"
     *     )
     * )
     */
    public function destroy(string $id)
    {
        TblFaculte::where('id', $id)->delete();
        return response()->noContent();
    }
}
