<?php

namespace Modules\Core\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class AdministrativeStructure extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = ['nombre', 'tipo', 'parent_id'];

    /**
     * Get the parent structure.
     */
    public function parent(): BelongsTo
    {
        return $this->belongsTo(AdministrativeStructure::class, 'parent_id');
    }

    /**
     * Get the children structures.
     */
    public function children(): HasMany
    {
        return $this->hasMany(AdministrativeStructure::class, 'parent_id');
    }

    /**
     * Get the positions belonging to this structure.
     */
    public function positions(): HasMany
    {
        return $this->hasMany(Position::class);
    }

    /**
     * Get the employees belonging to this structure (via position).
     */
    public function employees(): HasMany
    {
        return $this->hasManyThrough(Employee::class, Position::class, 'administrative_structure_id', 'position_id');
    }
}
