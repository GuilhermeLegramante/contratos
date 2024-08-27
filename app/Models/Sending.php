<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Sending extends Model
{
    use HasFactory;

    protected $fillable = [
        'situation',
        'number',
        'date',
        'protocol',
        'emission_date',
        'info',
        'value',
        'aliquot',
        'iss_value',
        'net_value',
        'rps',
        'competence_date',
        'contract_id',
        'cnae_id',
    ];

    public function contract(): BelongsTo
    {
        return $this->belongsTo(Contract::class, 'contract_id');
    }

    public function services(): BelongsToMany
    {
        return $this->belongsToMany(Service::class);
    }
}
