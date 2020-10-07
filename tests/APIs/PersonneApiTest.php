<?php namespace Tests\APIs;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\Personne;

class PersonneApiTest extends TestCase
{
    use ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function test_create_personne()
    {
        $personne = factory(Personne::class)->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/personnes', $personne
        );

        $this->assertApiResponse($personne);
    }

    /**
     * @test
     */
    public function test_read_personne()
    {
        $personne = factory(Personne::class)->create();

        $this->response = $this->json(
            'GET',
            '/api/personnes/'.$personne->id
        );

        $this->assertApiResponse($personne->toArray());
    }

    /**
     * @test
     */
    public function test_update_personne()
    {
        $personne = factory(Personne::class)->create();
        $editedPersonne = factory(Personne::class)->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/personnes/'.$personne->id,
            $editedPersonne
        );

        $this->assertApiResponse($editedPersonne);
    }

    /**
     * @test
     */
    public function test_delete_personne()
    {
        $personne = factory(Personne::class)->create();

        $this->response = $this->json(
            'DELETE',
             '/api/personnes/'.$personne->id
         );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/personnes/'.$personne->id
        );

        $this->response->assertStatus(404);
    }
}
