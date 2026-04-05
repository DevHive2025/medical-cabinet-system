<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model; 
use Illuminate\Database\Eloquent\Factories\HasFactory;
class Consultation extends Model
{
    use HasFactory;
    protected $fillable = ['date', 'compte_rendu', 'diagnostic', 'rendez_vous_id']; 

    public function ordonnances() {
        return $this->hasMany(Ordonnance::class); 
    }
}
?>