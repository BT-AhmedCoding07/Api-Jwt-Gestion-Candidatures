<?php
use function Pest\Laravel\postJson;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Testing\RefreshDatabase;
test('User can login', function () {
    // dump('Starting the test...');
    // Créer un utilisateur simulé av
    postJson('api/login', [
        'email' => $user['email'],
        'password' => $user['password'], // Mot de passe défini dans la factory
    ])->assertStatus(200)->assertJsonStructure(['message']);
});
