<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Contract extends Model
{
    use HasFactory;

    protected $fillable = [
        'number',
        'client_id',
        'hiring_method_id',
        'start_date',
        'end_date',
        'global_value',
        'monthly_value',
        'file',
        'is_active',
        'addendum_quantity',
    ];

    protected $casts = [
        'is_active' => 'boolean'
    ];

    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class);
    }

    public function hiringMethod(): BelongsTo
    {
        return $this->belongsTo(HiringMethod::class);
    }

    public function softwares(): BelongsToMany
    {
        return $this->belongsToMany(Software::class);
    }

    public function addendums(): HasMany
    {
        return $this->hasMany(Addendum::class);
    }
}
