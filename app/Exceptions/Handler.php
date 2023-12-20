<?php

namespace App\Exceptions;

use http\Client\Response;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Client\HttpClientException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * The list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     */
    public function register(): void
    {
        // On modifier le comportement pour l'exception NotFoundHttpException

        $this->renderable(function (AuthorizationException $e, $request) {
            // Si la requête contient "api/*"
            if ($request->is("api/*")) {
                // On retourne une réponse 404 avec un message en JSON
                return response()->json([
                    "statut" => 403,
                    "message" => "Acces non autorisé"
                ]);
            }
        });
        $this->renderable(function (HttpClientException $e, $request) {
            // Si la requête contient "api/*"
            if ($request->is("api/*")) {
                // On retourne une réponse 404 avec un message en JSON
                return response()->json([
                    "statut" => 500,
                    "message" => "Erreur interne du serveur"
                ]);
            }
        });

    }
}
