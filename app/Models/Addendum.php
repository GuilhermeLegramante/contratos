<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Addendum extends Model
{
    use HasFactory;

    protected $fillable = [
        'number',
        'contract_id',
        'adjustment_index_id',
        'start_date',
        'end_date',
        'global_value',
        'monthly_value',
        'file',
        'adjustment_percentual',
        'is_active'
    ];

    protected $casts = [
        'global_value' => 'double',
        'monthly_value' => 'double',
        'adjustment_percentual' => 'double',
        'is_active' => 'boolean'
    ];

    public function contract(): BelongsTo
    {
        return $this->belongsTo(Contract::class);
    }
}
