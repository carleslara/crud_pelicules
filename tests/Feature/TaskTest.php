<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;
use App\Models\Pelicula;

class TaskTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Un usuari no autenticat ha de ser redirigit al login quan accedeix a /home.
     */
    public function test_guest_is_redirected_to_login_when_accessing_home(): void
    {
        $response = $this->get('/home');

        // Laravel normalment redirigeix al login (302)
        $response->assertStatus(302);
        $response->assertRedirect('/login');

        $this->fail('Prova intencional: fallo el test.');
    }

    /**
     * Un usuari autenticat pot accedir a /home.
     */
    public function test_authenticated_user_can_access_home(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get('/home');

        $response->assertStatus(200);
        // Opcional: comprova que la vista conté el text "Pel·lícules"
        $response->assertSee('Pel·lícules');
    }

    /**
     * L'endpoint API GET /api/pelicula ha de retornar un paginator amb la forma esperada.
     */
    public function test_api_index_returns_paginated_movies(): void
    {
        // Creem algunes pel·lícules perquè hi hagi dades
        Pelicula::factory()->count(15)->create();

        $response = $this->getJson('/api/pelicula');

        $response->assertStatus(200)
                 ->assertJsonStructure([
                     'data',
                     'current_page',
                     'last_page',
                     'per_page',
                     'total'
                 ]);

        // Assegurem que retorna array de dades
        $this->assertIsArray($response->json('data'));
    }

    /**
     * POST /api/pelicula crea una pel·lícula amb dades vàlides; i valida errors.
     */
    public function test_api_store_creates_movie_and_validates(): void
    {
        $validPayload = [
            'titol' => 'Test Movie',
            'director' => 'Director Test',
            'genere' => 'Drama',
            'any_estrena' => 2020,
            'duracio' => 120,
            'valoracio' => 8.5,
        ];

        // Creació amb dades vàlides
        $response = $this->postJson('/api/pelicula', $validPayload);

        $response->assertStatus(201)
                 ->assertJson([
                     'created' => true,
                 ]);

        // Comprovem que la BD té la pel·lícula
        $this->assertDatabaseHas('peliculas', [
            'titol' => 'Test Movie',
            'director' => 'Director Test'
        ]);

        // Enviament amb dades invàlides (titol obligatori)
        $invalidPayload = [
            // 'titol' => missing
            'director' => 'X',
        ];

        $response2 = $this->postJson('/api/pelicula', $invalidPayload);

        // L'API ha de retornar 422 amb errors
        $response2->assertStatus(422)
                  ->assertJsonStructure(['created', 'errors']);
    }
}
