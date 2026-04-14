<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OrdonnanceLigne extends Model
{
    use HasFactory;

    protected $fillable = [
        'ordonnance_id',
        'medicament',
        'dose',
        'posologie',
        'duree',
    ];

    public function ordonnance(): BelongsTo
    {
        return $this->belongsTo(Ordonnance::class);
    }
}