<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Resources\OrganisationResource;
use App\Services\OrganisationService;

/**
 * Class OrganisationController
 * @package App\Http\Controllers
 */
class OrganisationController extends ApiController
{
    /**
     * Store a newly created organisation in the DB
     */
    public function store(OrganisationService $service)
    {
        $organisation = $service->createOrganisation($this->request->all());

        return new OrganisationResource($organisation);
    }

    /**
     * Display all organisations and filter if requested
     */
    public function index(OrganisationService $service)
    {
        return OrganisationResource::collection(
            $service->getFilteredOrganisations($this->request->get('filter'), ['owner'])
        );
    }
}
