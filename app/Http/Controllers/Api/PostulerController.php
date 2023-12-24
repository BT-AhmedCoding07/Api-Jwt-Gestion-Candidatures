<?php
/**
 * @OA\Tag(
 *     name="Candidatures",
 *     description="Opérations sur les candidatures"
 * )
 */
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Postuler;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PostulerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): \Illuminate\Http\JsonResponse
    {

        $listes = Postuler::all();
        return response()->json([
            "status" => true,
            "messages" => "Listes des candidatures",
            "candidatures" => $listes
        ]);
    }
    /**
     * @OA\Post(
     *     path="api/postuler",
     *     summary="Envoi d'une candidature",
     *     tags={"Candidatures"},
     *     security={{"bearerAuth": {}}},
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/x-www-form-urlencoded",
     *             @OA\Schema(
     *                 @OA\Property(property="referentiel_id", type="integer"),
     *             )
     *         )
     *     ),
     *     @OA\Response(response="200", description="Candidature enregistrée avec succès"),
     *     @OA\Response(response="422", description="Erreur de validation"),
     * )
     */
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $request->validate([
            'referentiel_id' => 'required|exists:referentiels,id',
        ]);
       dd(Auth::guard('api')->user());
        $postuler = new Postuler();
        $postuler->user_id = Auth::guard('api')->user()->id;
        $postuler->referentiel_id = $request->referentiel_id;
        $postuler->status = 'En attente';
        $postuler->save();

        return response()->json(data:
            [
            'status' => true,
            'message' => 'Candidature enregistrée avec succès'
            ]);
    }
    /**
     * @OA\Get(
     *     path="api/postuler/{id}",
     *     summary="Détails d'une candidature",
     *     tags={"Candidatures"},
     *     security={{"bearerAuth": {}}},
     *     @OA\Response(response="200", description="Détails de la candidature"),
     *     @OA\Response(response="404", description="Candidature non trouvée"),
     * )
     */
    /**
     * Display the specified resource.
     */
    public function show($id): \Illuminate\Http\JsonResponse
    {
        $candidat = Postuler::findOrFail($id);

        return response()->json($candidat);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }
    /**
     * @OA\Put(
     *     path="api/postuler/{id}/accept",
     *     summary="Accepter une candidature",
     *     tags={"Candidatures"},
     *     security={{"bearerAuth": {}}},
     *     @OA\Response(response="200", description="Candidature acceptée avec succès"),
     *     @OA\Response(response="404", description="Candidature non trouvée"),
     * )
     */
    public function accept($id): \Illuminate\Http\JsonResponse
    {
        $postuler = Postuler::findOrFail($id);
        $postuler->status = 'Accepté';
        $postuler->save();

        return response()->json([
            'status' => true,
            'message' => 'Candidature acceptée avec succès',
        ]);
    }
    /**
     * @OA\Put(
     *     path="api/postuler/{id}/reject",
     *     summary="Refuser une candidature",
     *     tags={"Candidatures"},
     *     security={{"bearerAuth": {}}},
     *     @OA\Response(response="200", description="Candidature refusée avec succès"),
     *     @OA\Response(response="404", description="Candidature non trouvée"),
     * )
     */
    public function rejet($id): \Illuminate\Http\JsonResponse
    {
        $postuler = Postuler::findOrFail($id);
        $postuler->status = 'Refusé';
        $postuler->save();

        return response()->json([
            'status' => true,
            'message' => 'Candidature refusée avec succès',
        ]);
    }
    /**
     * @OA\Delete(
     *     path="api/postuler/{id}",
     *     summary="Supprimer une candidature",
     *     tags={"Candidatures"},
     *     security={{"bearerAuth": {}}},
     *     @OA\Response(response="200", description="Candidature supprimée avec succès"),
     *     @OA\Response(response="404", description="Candidature non trouvée"),
     * )
     */
    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $candidat = Postuler::findOrFail($id);
        $candidat->delete();

        return response()->json([
            'status' => true,
            'message' => 'Candidature supprimée avec succès'
        ]);

    }

}
