<?php

declare(strict_types=1);

namespace App\Transformers;

use App\Models\Organisation;
use League\Fractal\Resource\Item;
use League\Fractal\TransformerAbstract;

/**
 * Class OrganisationTransformer
 * @package App\Transformers
 */
class OrganisationTransformer extends TransformerAbstract
{
    /**
     * @param Organisation $organisation
     *
     * @return array
     */
    public function transform(Organisation $organisation): array
    {
        return [
            'id' => $organisation->id,
            'name' => $organisation->name,
            'owner' => $this->includeUser(),
            'trial_end' => $organisation->trial_end,
            'subscribed' => $organisation->subscribed,
            'created_at' => $organisation->created_at->toDateTimeString(),
            'updated_at' => $organisation->updated_at->toDateTimeString(),
        ];
    }

    /**
     * @param Organisation $organisation
     *
     * @return \League\Fractal\Resource\Item
     */
    public function includeUser(Organisation $organisation): Item
    {
        return $this->item($organisation->owner, new UserTransformer());
    }
}
