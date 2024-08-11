<?php

namespace App\Http\Controllers\Ressources;

use App\Http\Controllers\Controller;
use App\Models\TblCategorie;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Services\FileUploadService;

class TblCategorieController extends Controller
{

    private $fileUploadService;

    public function __construct(FileUploadService $fileUploadService)
    {
        $this->fileUploadService = $fileUploadService;
    }
    /**
     * @OA\Get(
     *     path="/api/ressources/categories",
     *     operationId="getCategoriesList",
     *     tags={"Categories"},
     *     summary="Get list of categories",
     *     description="Returns list of categories",
     *     @OA\Response(
     *         response=200,
     *         description="successful operation",
     *         @OA\JsonContent(type="array", @OA\Items(ref="#/components/schemas/TblCategorie"))
     *     )
     * )
     */
    public function index()
    {
        $categorie = TblCategorie::all();
        return response()->json($categorie);
    }

    /**
     * @OA\Post(
     *     path="/api/ressources/categories",
     *     operationId="storeCategory",
     *     tags={"Categories"},
     *     summary="Create a new category",
     *     description="Creates a new category and returns it",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="nom_cat", type="string", description="Name of the category"),
     *             @OA\Property(property="descript_cat", type="string", description="Description of the category")
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="successful operation",
     *         @OA\JsonContent(ref="#/components/schemas/TblCategorie")
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Validation error",
     *         @OA\JsonContent(
     *             @OA\Property(property="errors", type="object", description="Validation errors")
     *         )
     *     )
     * )
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nom_cat'=>'required|unique:tbl_categories,nom_cat|max:255',
            'descript_cat'=>'required|unique:tbl_categories,descript_cat|max:255',
            'icone' => 'required|mimes:svg,png,ico',

        ]);
        if($validator->fails()){
            return response()->json(['errors' => $validator->errors()], 400);
        }

        $iconeUrl = $this->fileUploadService->uploadFile($request->file('icone'), 'public/icones');

        $categorie = TblCategorie::create([
            'nom_cat' => $request->nom_cat,
            "descript_cat"=>$request->descript_cat,
            'icone' => $iconeUrl,

        ]);
        return response()->json($categorie);
    }

    /**
     * @OA\Get(
     *     path="/api/ressources/categories/{id}",
     *     operationId="getCategoryById",
     *     tags={"Categories"},
     *     summary="Get category by ID",
     *     description="Returns a single category",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="string"),
     *         description="ID of the category"
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="successful operation",
     *         @OA\JsonContent(ref="#/components/schemas/TblCategorie")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Category not found"
     *     )
     * )
     */
    public function show(string $id)
    {
        $categorie = TblCategorie::where('id', $id)->firstOrFail();
        return response()->json($categorie);
    }

    /**
     * @OA\Put(
     *     path="/api/ressources/categories/{id}",
     *     operationId="updateCategory",
     *     tags={"Categories"},
     *     summary="Update an existing category",
     *     description="Updates a category and returns it",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="string"),
     *         description="ID of the category"
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="nom_cat", type="string", description="Name of the category"),
     *             @OA\Property(property="descript_cat", type="string", description="Description of the category")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="successful operation",
     *         @OA\JsonContent(ref="#/components/schemas/TblCategorie")
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Validation error",
     *         @OA\JsonContent(
     *             @OA\Property(property="errors", type="object", description="Validation errors")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Category not found"
     *     )
     * )
     */
    public function update(Request $request, string $id)
    {
        $validator = Validator::make($request->all(), [
            'nom_cat'=>'required|max:255',
            'descript_cat'=>'required',
            'icone' => 'required|mimes:svg,png,ico',
        ]);
        if($validator->fails()){
            return response()->json(['errors' => $validator->errors()], 400);
        }

        $categorie = TblCategorie::where('id', $id)->firstOrFail();
        $categorie->nom_cat = $request->nom_cat;
        $categorie->descript_cat = $request->descript_cat;

        if ($request->hasFile('icone')) {
            // Supprimer l'image précédente si elle existe
            if ($categorie->image) {
                $this->fileUploadService->deleteFile($categorie->icone);
            }

            // Télécharger la nouvelle image
            $iconeUrl = $this->fileUploadService->uploadFile($request->file('icone'), 'public/icones');
            $categorie->icone = $iconeUrl;
        }

        $categorie->save();

        return response()->json($categorie);

    }

    /**
     * @OA\Delete(
     *     path="/api/ressources/categories/{id}",
     *     operationId="deleteCategory",
     *     tags={"Categories"},
     *     summary="Delete a category",
     *     description="Deletes a category",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="string"),
     *         description="ID of the category"
     *     ),
     *     @OA\Response(
     *         response=204,
     *         description="No content"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Category not found"
     *     )
     * )
     */
    public function destroy(string $id)
    {
        TblCategorie::where('id', $id)->delete();
        return response()->noContent();
    }
}
