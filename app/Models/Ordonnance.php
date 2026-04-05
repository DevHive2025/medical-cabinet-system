<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model; 
use Illuminate\Database\Eloquent\Factories\HasFactory;
class Ordonnance extends Model
{
    use HasFactory;

    protected $fillable = [
        'consultation_id',
        'date_emission',
        'contenu_medicaments',
        'duree_traitement',
    ];

    public function consultation()
    {
        return $this->belongsTo(Consultation::class);
    }

    public function genererPDF()
    {
        // later: dompdf / snappy
    }
}
?>