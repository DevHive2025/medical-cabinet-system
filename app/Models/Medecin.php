<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model; 
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany; 

class Medecin extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'specialite', 'cabinet_telephone'];

    public function user() {
        return $this->belongsTo(User::class);
    }
    public function rendezVous(): HasMany
    {
        return $this->hasMany(RendezVous::class, 'medecin_id');
    }
}