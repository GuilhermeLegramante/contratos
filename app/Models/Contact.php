<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Contact extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'whatsapp',
        'note',
    ];

    protected $casts = [
        'clients' => 'array',
    ];

    public function clients(): BelongsToMany
    {
        return $this->belongsToMany(Client::class);
    }
}
