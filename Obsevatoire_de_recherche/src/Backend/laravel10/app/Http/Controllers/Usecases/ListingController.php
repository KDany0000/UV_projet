<?php

namespace App\Http\Controllers\Usecases;

use App\Http\Controllers\Controller;
use App\Models\TblCategorie;
use App\Models\TblNiveau;
use App\Models\TblProjet;
use App\Models\User;
use Illuminate\Http\Request;

class ListingController extends Controller
{
    /**
     * @OA\Get(
     *     path="/categories/{id}/projects",
     *     operationId="showProjects",
     *     tags={"Categories"},
     *     summary="Get projects by category ID",
     *     description="Returns a list of projects associated with the given category ID",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer"),
     *         description="Category ID"
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful response",
     *         @OA\JsonContent(type="array", @OA\Items(ref="#/components/schemas/TblProjet"))
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Category not found"
     *     )
     * )
     */
    public function showProjects($id)
    {
        // Récupérer la catégorie par son ID
        $categorie = TblCategorie::findOrFail($id);

        // Récupérer les projets associés à cette catégorie
        $projets = $categorie->projets;

        // Retourner les projets
        return response()->json($projets);
    }

    /**
     * @OA\Get(
     *     path="/projects/{id}/documents",
     *     operationId="showDocuments",
     *     tags={"Projects"},
     *     summary="Get documents by project ID",
     *     description="Returns a list of documents associated with the given project ID",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer"),
     *         description="Project ID"
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful response",
     *         @OA\JsonContent(type="array", @OA\Items(ref="#/components/schemas/TblDocument"))
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Project not found"
     *     )
     * )
     */
    public function showDocuments($id)
    {
        // Récupérer le projet par son ID
        $projet = TblProjet::findOrFail($id);

        // Récupérer les documents associés à ce projet
        $documents = $projet->documents;

        // Retourner les documents
        return response()->json($documents);
    }

    /**
     * @OA\Get(
     *     path="/levels/{id}/projects",
     *     operationId="showLevelProjects",
     *     tags={"Levels"},
     *     summary="Get projects by level ID",
     *     description="Returns a list of projects associated with the given level ID",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer"),
     *         description="Level ID"
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful response",
     *         @OA\JsonContent(type="array", @OA\Items(ref="#/components/schemas/TblProjet"))
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Level not found"
     *     )
     * )
     */
    public function showLevelProjects($id)
    {
        // Récupérer le niveau par son ID
        $niveau = TblNiveau::findOrFail($id);

        // Récupérer les projets associés à ce niveau
        $projets = $niveau->projets;

        // Retourner les projets
        return response()->json($projets);
    }

    /**
     * @OA\Get(
     *     path="/users/{id}/projects",
     *     operationId="showUserProjects",
     *     tags={"Users"},
     *     summary="Get projects by user ID",
     *     description="Returns a list of projects associated with the given user ID",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer"),
     *         description="User ID"
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful response",
     *         @OA\JsonContent(type="array", @OA\Items(ref="#/components/schemas/TblProjet"))
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="User not found"
     *     )
     * )
     */
    public function showUserProjects($id)
    {
        // Récupérer l'utilisateur par son ID
        $user = User::findOrFail($id);

        // Récupérer les projets associés à cet utilisateur
        $projets = $user->projets;

        // Retourner les projets
        return response()->json($projets);
    }

    /**
     * @OA\Get(
     *     path="/users/{id}/documents",
     *     operationId="showUserDocuments",
     *     tags={"Users"},
     *     summary="Get documents by user ID",
     *     description="Returns a list of documents associated with the given user ID",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer"),
     *         description="User ID"
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful response",
     *         @OA\JsonContent(type="array", @OA\Items(ref="#/components/schemas/TblDocument"))
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="User not found"
     *     )
     * )
     */
    public function showUserDocuments($id)
    {
        // Récupérer l'utilisateur par son ID
        $user = User::findOrFail($id);

        // Récupérer les documents associés à cet utilisateur
        $documents = $user->documents;

        // Retourner les documents
        return response()->json($documents);
    }
}
