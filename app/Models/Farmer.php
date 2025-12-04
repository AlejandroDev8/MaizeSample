<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Farmer extends Model
{
    protected $fillable = [
        'name',
        'phone',
        'address',
        'state_id',
        'municipality_id',
        'locality_id',
    ];

    // Relaciones directas por las foreign keys del farmer
    public function state()
    {
        return $this->belongsTo(State::class);
    }

    public function municipality()
    {
        return $this->belongsTo(Municipality::class);
    }

    public function locality()
    {
        return $this->belongsTo(Locality::class);
    }
}
