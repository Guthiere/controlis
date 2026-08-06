<?php

namespace Modules\Core\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Position extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = ['nombre', 'administrative_structure_id'];

    /**
     * Get the administrative structure this position belongs to.
     */
    public function administrativeStructure(): BelongsTo
    {
        return $this->belongsTo(AdministrativeStructure::class, 'administrative_structure_id');
    }

    /**
     * Get the employees assigned to this
     */
    public function employees(): HasMany
    {
        return $this->hasMany(Employee::class);
    }
}
