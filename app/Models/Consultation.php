<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model; 
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
class Consultation extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = ['date', 'compte_rendu','symptomes', 'diagnostic', 'rendez_vous_id']; 

    public function ordonnances() {
        return $this->hasMany(Ordonnance::class);
    }

    public function rendezVous() {
        return $this->belongsTo(RendezVous::class, 'rendez_vous_id');
    }
}
?>