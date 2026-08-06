<?php

namespace Modules\Core\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class GeographicalDivision extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = ['nombre', 'tipo', 'parent_id'];

    /**
     * Get the parent division.
     */
    public function parent(): BelongsTo
    {
        return $this->belongsTo(GeographicalDivision::class, 'parent_id');
    }

    /**
     * Get the child divisions.
     */
    public function children(): HasMany
    {
        return $this->hasMany(GeographicalDivision::class, 'parent_id');
    }
}
