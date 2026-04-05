<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model; 
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DossierMedical extends Model
{
    use HasFactory;
    protected $fillable = ['patient_id', 'historique', 'antecedents', 'allergies']; // [cite: 50, 52]

    public function patient() {
        return $this->belongsTo(Patient::class);
    }
} ?>
