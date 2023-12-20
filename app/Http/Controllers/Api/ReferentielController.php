<?php
/**
 * @OA\Tag(
 *     name="Referentiels",
 *     description="Opérations sur les referentiels"
 * )
 */
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Referentiel;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class ReferentielController extends Controller
{
    /**
     * @OA\Get(
     *     path="/referentiels",
     *     summary="Liste des referentiels",
     *     tags={"Referentiels"},
     *     security={{"bearerAuth": {}}},
     *     @OA\Response(response="200", description="Liste des referentiels"),
     * )
     */

    /**
     * Display a listing of the resource.
     */
    public function index(): \Illuminate\Http\JsonResponse
    {
        $referentiels = Referentiel::all();

        return response()->json($referentiels);
    }
    /**
     * @OA\Post(
     *     path="/referentiels",
     *     summary="Création d'un referentiel",
     *     tags={"Referentiels"},
     *     security={{"bearerAuth": {}}},
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/x-www-form-urlencoded",
     *             @OA\Schema(
     *                 @OA\Property(property="nom", type="string"),
     *                 @OA\Property(property="description", type="string"),
     *                 @OA\Property(property="domaine", type="string"),
     *             )
     *         )
     *     ),
     *     @OA\Response(response="200", description="Referentiel créé avec succès"),
     *     @OA\Response(response="422", description="Erreur de validation"),
     * )
     */

    /**
     * Store a newly created resource in storage.
     * @throws ValidationException
     */
    public function store(Request $request): \Illuminate\Http\JsonResponse
    {
        $request->validate([
            'nom_referentiel' => 'required|max:100',
            'echeance' => 'required',
            'description' => 'required',
        ]);

        $referentiel = Referentiel::create([
            'nom_referentiel' => $request->nom_referentiel,
            'echeance' => $request->echeance,
            'description' => $request->description,
        ]);

        // On retourne les informations du nouvel refentiel en JSON
        return response()->json([
            "status" => 201,
            "referentiel" => $referentiel,
            "message" => "Create Referentiel in successfully"
        ]);
    }
    /**
     * @OA\Get(
     *     path="/referentiels/{referentiel}",
     *     summary="Détails d'un referentiel",
     *     tags={"Referentiels"},
     *     security={{"bearerAuth": {}}},
     *     @OA\Response(response="200", description="Détails du referentiel"),
     *     @OA\Response(response="404", description="Referentiel non trouvé"),
     * )
     */

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $referentiel = Referentiel::findOrFail($id);

        return response()->json($referentiel);
    }

    /**
     * @OA\Put(
     *     path="/referentiels/{referentiel}",
     *     summary="Mise à jour d'un referentiel",
     *     tags={"Referentiels"},
     *     security={{"bearerAuth": {}}},
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/x-www-form-urlencoded",
     *             @OA\Schema(
     *                 @OA\Property(property="nom", type="string"),
     *                 @OA\Property(property="description", type="string"),
     *                 @OA\Property(property="domaine", type="string"),
     *             )
     *         )
     *     ),
     *     @OA\Response(response="200", description="Referentiel mis à jour avec succès"),
     *     @OA\Response(response="404", description="Referentiel non trouvé"),
     *     @OA\Response(response="422", description="Erreur de validation"),
     * )
     */

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request,  $id)
    {
        // La validation de données
        $request->validate([
            'nom_referentiel' => 'required|max:100',
            'echeance' => 'required',
            'description' => 'required',
        ]);

        $referentiel = Referentiel::findOrFail($id);
        $referentiel->update([
            'nom_referentiel' => $request->nom_referentiel,
            'echeance' => $request->echeance,
            'description' => $request->description,
        ]);

        // On retourne la réponse JSON
        return response()->json(
            ["status" => 201,
            $referentiel,
            "message" => "Update Referentiel in successfully"
            ]);
    }
    /**
     * @OA\Delete(
     *     path="/referentiels/{referentiel}",
     *     summary="Suppression d'un referentiel",
     *     tags={"Referentiels"},
     *     security={{"bearerAuth": {}}},
     *     @OA\Response(response="200", description="Referentiel supprimé avec succès"),
     *     @OA\Response(response="404", description="Referentiel non trouvé"),
     * )
     */

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id): \Illuminate\Http\JsonResponse
    {
        $referentiel = Referentiel::findOrFail($id);
        $referentiel->delete();

        return response()->json(['status' => true, 'message' => 'Referentiel supprimé avec succès']);

    }
}
