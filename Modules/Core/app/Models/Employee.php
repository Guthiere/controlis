<?php

namespace Modules\Core\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Employee extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'dni',
        'nombre',
        'apellido',
        'email',
        'telefono',
        'position_id',
    ];

    /**
     * Get the position this employee belongs to.
     */
    public function position(): BelongsTo
    {
        return $this->belongsTo(Position::class);
    }
}
