<?php
/**
 * @OA\Info(
 *     title="API de Gestion des Candidatures",
 *     version="1.0",
 *     description="API pour gérer les candidatures et les référentiels."
 * )
 * @OA\Server(
 *     url="http://127.0.0.1:8000/api",
 *     description="Serveur de développement"
 * )
 * @OA\SecurityScheme(
 *     securityScheme="bearerAuth",
 *     type="http",
 *     scheme="bearer",
 *     bearerFormat="JWT",
 * )
 */
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Facades\JWTAuth;

class ApiController extends Controller
{

    //Function Retour reponse json
    private function jsonResponse($status, $message, $data = null): \Illuminate\Http\JsonResponse
    {
        return response()->json([
            'status' => $status,
            'message' => $message,
            'data' => $data,
        ]);
    }
    /**
     * @OA\Post(
     *     path="/register",
     *     summary="Enregistrement d'un utilisateur",
     *     tags={"Authentification"},
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/x-www-form-urlencoded",
     *             @OA\Schema(
     *                 @OA\Property(property="nom", type="string"),
     *                 @OA\Property(property="email", type="string"),
     *                 @OA\Property(property="telephone", type="string"),
     *                 @OA\Property(property="password", type="string"),
     *                 @OA\Property(property="password_confirmation", type="string"),
     *             )
     *         )
     *     ),
     *     @OA\Response(response="200", description="Utilisateur enregistré avec succès"),
     *     @OA\Response(response="422", description="Erreur de validation"),
     * )
     */
    //Register API {POST, FormData}
    public function register(Request $request): \Illuminate\Http\JsonResponse
    {
        // data validation
        $request->validate([
            "nom" => "required",
            "email" => "required|email|unique:users",
            "telephone" => "required|max:9|unique:users",
            "password" => "required|confirmed"
        ]);

        // User Model
        User::create([
            "nom" => $request->nom,
            "email" => $request->email,
            "telephone" => $request->telephone,
            "password" => Hash::make($request->password)
        ]);

        // Response
        return $this->jsonResponse(true, "User registered successfully");

    }
    /**
     * @OA\Post(
     *     path="/login",
     *     summary="Connexion de l'utilisateur",
     *     tags={"Authentification"},
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/x-www-form-urlencoded",
     *             @OA\Schema(
     *                 @OA\Property(property="email", type="string"),
     *                 @OA\Property(property="password", type="string"),
     *             )
     *         )
     *     ),
     *     @OA\Response(response="200", description="Utilisateur connecté avec succès"),
     *     @OA\Response(response="401", description="Identifiants invalides"),
     * )
     */
    //Login API {POST, FormData}
    public function login(Request $request)
    {
        //Data validation
        $request->validate([
            "email" => "required|email",
            "password" => "required"
        ]);
        //JWTAuth and attempt
        $token  = JWTAuth::attempt([
         "email" => $request->email,
         "password" => $request->password,
        ]);
        if(!empty($token)){

           return response()->json([
           "status" => true,
           "message" => "User logged in succcessfully",
           "token" => $token
           ]);


        }

        return response()->json([
            "status" => false,
            "message" => "Invalid details"
        ]);

    }
    /**
     * @OA\Get(
     *     path="/profile",
     *     summary="Profil de l'utilisateur",
     *     tags={"Profil"},
     *     security={{"bearerAuth": {}}},
     *     @OA\Response(response="200", description="Données du profil de l'utilisateur"),
     * )
     */
    //Profile API{GET}
    // User Profile (GET)
    public function profile(): \Illuminate\Http\JsonResponse
    {

        $userdata = auth()->user();
        /*
         * return response()->json([
            "status" => true,
            "message" => "Profile data",
            "data" => $userdata
        ]);
         */
        return $this->jsonResponse(true, "Profile data", $userdata);

    }
    /**
     * @OA\Get(
     *     path="/refresh",
     *     summary="Actualisation du jeton d'accès",
     *     tags={"Authentification"},
     *     security={{"bearerAuth": {}}},
     *     @OA\Response(response="200", description="Nouveau jeton d'accès généré avec succès"),
     * )
     */
    // To generate refresh token value
    public function refreshToken(): \Illuminate\Http\JsonResponse
    {

        $newToken = auth()->refresh();
        /*
         * return response()->json([
            "status" => true,
            "message" => "New access token",
            "token" => $newToken
        ]);
         */
        return $this->jsonResponse(true, "New access token", compact('newToken'));
    }
    /**
     * @OA\Post(
     *     path="/logout",
     *     summary="Déconnexion de l'utilisateur",
     *     tags={"Authentification"},
     *     security={{"bearerAuth": {}}},
     *     @OA\Response(response="200", description="Utilisateur déconnecté avec succès"),
     * )
     */
    // User Logout (GET)
    public function logout(): \Illuminate\Http\JsonResponse
    {

        auth()->logout();
        /*
         * return response()->json(data: [
            "status" => true,
            "message" => "User logged out successfully"
        ]);
         */
        return $this->jsonResponse(true, "User logged out successfully");
    }
}
