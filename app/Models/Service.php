<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Service extends Model
{
    use HasFactory;

    protected $fillable = [
        'cnae_id',
        'value',
        'aliquot',
        'description',
    ];

    public function cnae(): BelongsTo
    {
        return $this->belongsTo(Cnae::class, 'cnae_id');
    }
}
