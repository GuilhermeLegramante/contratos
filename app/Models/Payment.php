<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'number',
        'contract_id',
        'addendum_id',
        'date',
        'value',
        'payment_method_id',
    ];

    public function contract(): BelongsTo
    {
        return $this->belongsTo(Contract::class);
    }

    public function addendum(): BelongsTo
    {
        return $this->belongsTo(Addendum::class);
    }
}
