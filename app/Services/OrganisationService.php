<?php

declare(strict_types=1);

namespace App\Services;


use App\Models\Organisation;
use Illuminate\Support\Collection;

/**
 * Class OrganisationService
 * @package App\Services
 */
class OrganisationService
{
    /**
     * @param array $attributes
     *
     * @return Organisation
     */
    public function createOrganisation(array $attributes): Organisation
    {
        $organisation = new Organisation();

        return $organisation;
    }

    public function getOrganisations(string $filter = ''): Collection
    {
//        return Organisation::with($with)->get();
        return Organisation::all();
    }
}
