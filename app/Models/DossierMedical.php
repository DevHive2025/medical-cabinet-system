<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DossierMedical extends Model
{
    use HasFactory;

    protected $table = 'dossier_medicals';

    protected $fillable = [
        'patient_id',
        'groupe_sanguin',
        'maladies_chroniques',
        'antecedents',
        'allergies'
    ];

    public function patient(): BelongsTo
    {
        return $this->belongsTo(Patient::class, 'patient_id');
    }
}