<?php 
namespace App\Models;

use Illuminate\Database\Eloquent\Model; 
use Illuminate\Database\Eloquent\Factories\HasFactory;

class RendezVous extends Model
{
    use HasFactory;
    protected $table = 'rendez_vous';
    protected $fillable = ['date_heure', 'statut', 'motif', 'patient_id', 'medecin_id']; // [cite: 24, 25, 26]

    public function patient() {
        return $this->belongsTo(Patient::class);
    }

    public function medecin() {
        return $this->belongsTo(Medecin::class);
    }

    public function consultation() {
        return $this->hasOne(Consultation::class);
    }
}
?>