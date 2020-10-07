<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreatePersonneAPIRequest;
use App\Http\Requests\API\UpdatePersonneAPIRequest;
use App\Models\Personne;
use App\Repositories\PersonneRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use Response;

/**
 * Class PersonneController
 * @package App\Http\Controllers\API
 */

class PersonneAPIController extends AppBaseController
{
    /** @var  PersonneRepository */
    private $personneRepository;

    public function __construct(PersonneRepository $personneRepo)
    {
        $this->personneRepository = $personneRepo;
    }

    /**
     * Display a listing of the Personne.
     * GET|HEAD /personnes
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $personnes = $this->personneRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse($personnes->toArray(), 'Personnes retrieved successfully');
    }

    /**
     * Store a newly created Personne in storage.
     * POST /personnes
     *
     * @param CreatePersonneAPIRequest $request
     *
     * @return Response
     */
    public function store(CreatePersonneAPIRequest $request)
    {
        $input = $request->all();

        $personne = $this->personneRepository->create($input);

        return $this->sendResponse($personne->toArray(), 'Personne saved successfully');
    }

    /**
     * Display the specified Personne.
     * GET|HEAD /personnes/{id}
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var Personne $personne */
        $personne = $this->personneRepository->find($id);

        if (empty($personne)) {
            return $this->sendError('Personne not found');
        }

        return $this->sendResponse($personne->toArray(), 'Personne retrieved successfully');
    }

    /**
     * Update the specified Personne in storage.
     * PUT/PATCH /personnes/{id}
     *
     * @param int $id
     * @param UpdatePersonneAPIRequest $request
     *
     * @return Response
     */
    public function update($id, UpdatePersonneAPIRequest $request)
    {
        $input = $request->all();

        /** @var Personne $personne */
        $personne = $this->personneRepository->find($id);

        if (empty($personne)) {
            return $this->sendError('Personne not found');
        }

        $personne = $this->personneRepository->update($input, $id);

        return $this->sendResponse($personne->toArray(), 'Personne updated successfully');
    }

    /**
     * Remove the specified Personne from storage.
     * DELETE /personnes/{id}
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var Personne $personne */
        $personne = $this->personneRepository->find($id);

        if (empty($personne)) {
            return $this->sendError('Personne not found');
        }

        $personne->delete();

        return $this->sendSuccess('Personne deleted successfully');
    }
}
