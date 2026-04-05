<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'nom',
        'prenom',
        'email',
        'password',
        'role'
    ]; 

    public function medecin() {
        return $this->hasOne(Medecin::class);
    }

    public function patient() {
        return $this->hasOne(Patient::class);
    }

    public function secretaire() {
        return $this->hasOne(Secretaire::class);
    }
}