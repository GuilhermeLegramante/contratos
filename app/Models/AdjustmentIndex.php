<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class AdjustmentIndex extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'note'
    ];

    public function addendums(): HasMany
    {
        return $this->hasMany(Addendum::class);
    }
}
