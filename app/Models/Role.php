<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * @property string $name
 * @property string $slug
 * @property bool $is_system_role
 * @property Carbon $created_at
 * @property Carbon $updatedAt
 *
 * @property-read Collection|null $permissions
 */
class Role extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'is_system_role' => 'boolean',
    ];

    /**
     * Role's permissions
     *
     * @return BelongsToMany
     */
    public function permissions(): BelongsToMany
    {
        return $this->belongsToMany(Permission::class);
    }

    /**
     * Check whether this is system defined role or not
     *
     * @return bool
     */
    public function isSystemRole(): bool
    {
        return $this->is_system_role;
    }
}
