<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\OrganisationRequest;
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
    public function store(OrganisationRequest $request, OrganisationService $service)
    {
        $organisation = $service->createOrganisation($request->validated());

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
