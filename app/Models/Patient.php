<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model; 
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Patient extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = ['user_id', 'cin','genre', 'date_naissance', 'telephone']; 

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function dossierMedical() {
        return $this->hasOne(DossierMedical::class); 
    }

    public function rendezVous() {
        return $this->hasMany(RendezVous::class); 
    } 
    
    public function consultations(){
        return $this->hasManyThrough(Consultation::class, RendezVous::class);
    }
}
?>