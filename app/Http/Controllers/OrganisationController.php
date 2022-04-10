<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Organisation;
use App\Services\OrganisationService;
use App\Transformers\OrganisationTransformer;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

/**
 * Class OrganisationController
 * @package App\Http\Controllers
 */
class OrganisationController extends ApiController
{
    /**
     * @param OrganisationService $service
     *
     * @return JsonResponse
     */
    public function store(OrganisationService $service): JsonResponse
    {
        /** @var Organisation $organisation */
        $organisation = $service->createOrganisation($this->request->all());

        return $this
            ->transformItem('organisation', $organisation, ['user'])
            ->respond();
    }

    public function index(OrganisationService $service)
    {
        $filter = $this->request->get('filter') ?? false;

        $organisations = $this->transformCollection(
            'organisations',
            $service->getOrganisations($filter)
        );

        return $organisations->respond();

//        return fractal(Organisation::with(['owner'])->get(), new OrganisationTransformer())->respond();

//        $filteredOrganisations = [];
//
//        foreach ($organisations as $organisation) {
//
//            if ($filter) {
//                if ($filter = 'subbed') {
//                    if ($organisation['subscribed'] == 1) {
//                        array_push($filteredOrganisations, $organisation);
//                    }
//                } else if ($filter = 'trail') {
//                    if ($organisation['subbed'] == 0) {
//                        array_push($filteredOrganisations, $organisation);
//                    }
//                } else {
//                    array_push($filteredOrganisations, $organisation);
//                }
//            } else {
//                array_push($filteredOrganisations, $organisation);
//            }
//        }
//
//        return json_encode($filteredOrganisations);
    }
}
