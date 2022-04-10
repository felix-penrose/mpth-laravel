<?php

declare(strict_types=1);

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Organisation
 *
 * @property int         id
 * @property string      name
 * @property int         owner_user_id
 * @property Carbon      trial_end
 * @property bool        subscribed
 * @property Carbon      created_at
 * @property Carbon      updated_at
 * @property Carbon|null deleted_at
 * @package App
 * @property int $id
 * @property string $name
 * @property int $owner_user_id
 * @property string|null $trial_end
 * @property int $subscribed
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \App\Models\User|null $owner
 * @method static \Database\Factories\OrganisationFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|Organisation newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Organisation newQuery()
 * @method static \Illuminate\Database\Query\Builder|Organisation onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Organisation query()
 * @method static \Illuminate\Database\Eloquent\Builder|Organisation whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Organisation whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Organisation whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Organisation whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Organisation whereOwnerUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Organisation whereSubscribed($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Organisation whereTrialEnd($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Organisation whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|Organisation withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Organisation withoutTrashed()
 * @mixin \Eloquent
 */
class Organisation extends Model
{
    use SoftDeletes;
    use HasFactory;

    /**
     * @var array
     */
    protected $fillable = [];

    /**
     * @var array
     */
    protected $dates = [
        'deleted_at',
    ];

    /**
     * @return BelongsTo
     */
    public function owner(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
