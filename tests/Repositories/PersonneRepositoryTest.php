<?php namespace Tests\Repositories;

use App\Models\Personne;
use App\Repositories\PersonneRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;

class PersonneRepositoryTest extends TestCase
{
    use ApiTestTrait, DatabaseTransactions;

    /**
     * @var PersonneRepository
     */
    protected $personneRepo;

    public function setUp() : void
    {
        parent::setUp();
        $this->personneRepo = \App::make(PersonneRepository::class);
    }

    /**
     * @test create
     */
    public function test_create_personne()
    {
        $personne = factory(Personne::class)->make()->toArray();

        $createdPersonne = $this->personneRepo->create($personne);

        $createdPersonne = $createdPersonne->toArray();
        $this->assertArrayHasKey('id', $createdPersonne);
        $this->assertNotNull($createdPersonne['id'], 'Created Personne must have id specified');
        $this->assertNotNull(Personne::find($createdPersonne['id']), 'Personne with given id must be in DB');
        $this->assertModelData($personne, $createdPersonne);
    }

    /**
     * @test read
     */
    public function test_read_personne()
    {
        $personne = factory(Personne::class)->create();

        $dbPersonne = $this->personneRepo->find($personne->id);

        $dbPersonne = $dbPersonne->toArray();
        $this->assertModelData($personne->toArray(), $dbPersonne);
    }

    /**
     * @test update
     */
    public function test_update_personne()
    {
        $personne = factory(Personne::class)->create();
        $fakePersonne = factory(Personne::class)->make()->toArray();

        $updatedPersonne = $this->personneRepo->update($fakePersonne, $personne->id);

        $this->assertModelData($fakePersonne, $updatedPersonne->toArray());
        $dbPersonne = $this->personneRepo->find($personne->id);
        $this->assertModelData($fakePersonne, $dbPersonne->toArray());
    }

    /**
     * @test delete
     */
    public function test_delete_personne()
    {
        $personne = factory(Personne::class)->create();

        $resp = $this->personneRepo->delete($personne->id);

        $this->assertTrue($resp);
        $this->assertNull(Personne::find($personne->id), 'Personne should not exist in DB');
    }
}
