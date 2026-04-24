<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model; 
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
class Ordonnance extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'consultation_id',
        'reference',
        'date_ordonnance',
    ];

    public function consultation()
    {
        return $this->belongsTo(Consultation::class);
    }
    public function lignes()
    {
        return $this->hasMany(OrdonnanceLigne::class);
    }

    public function genererPDF()
    {
        // later: dompdf / snappy
    }
}
?>