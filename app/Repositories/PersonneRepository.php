<?php

namespace App\Repositories;

use App\Models\Personne;
use App\Repositories\BaseRepository;

/**
 * Class EntrepriseRepository
 * @package App\Repositories
 * @version October 7, 2020, 8:28 pm UTC
*/

class PersonneRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        
    ];

    /**
     * Return searchable fields
     *
     * @return array
     */
    public function getFieldsSearchable()
    {
        return $this->fieldSearchable;
    }

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Personne::class;
    }
}
