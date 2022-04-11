<?php

declare(strict_types=1);

namespace App\Services;

use App\Events\OrganisationCreationEvent;
use Carbon\Carbon;
use App\Models\Organisation;
use Illuminate\Support\Collection;

/**
 * Class OrganisationService
 * @package App\Services
 */
class OrganisationService
{
    const TRIAL_PERIOD = 30;

    /**
     * @param array $attributes
     *
     * @return Organisation
     */
    public function createOrganisation(array $attributes): Organisation
    {
        if (! $attributes['subscribed']) {
            $attributes['trial_end'] = Carbon::now()->addDays(self::TRIAL_PERIOD)->format('Y-m-d H:i:s');
        }

        $organisation = Organisation::create($attributes);

        OrganisationCreationEvent::dispatch($organisation);

        return $organisation;
    }

    /**
     * Get all organisations with optional filtering and eager loading
     */
    public function getFilteredOrganisations(?string $filter = '', array $with = []): Collection
    {
        $organisations = Organisation::with($with)
            ->when($filter, function ($query) use ($filter) {
                if ($filter === 'subbed') {
                    $query->where('subscribed', 1);
                } elseif ($filter === 'trial') {
                    $query->where('trial_end', '>', now());
                }
            })
            ->get();

        return $organisations;
    }
}
