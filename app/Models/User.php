<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\DB;

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

    const ROLE_ADMIN = 'admin';
    const ROLE_MEDECIN = 'medecin';
    const ROLE_SECRETAIRE = 'secretaire';
    const ROLE_PATIENT = 'patient';

    protected function casts(): array
    {
        return [
            'last_login_at' => 'datetime', 
        ];
    }

    public function isOnline()
    {
        return DB::table('sessions')
            ->where('user_id', $this->id)
            ->where('last_activity', '>', now()->subMinutes(5)->getTimestamp())
            ->exists();
    }
    public function isAdmin(): bool
    {
        return $this->role === self::ROLE_ADMIN;
    }

    public function isMedecin(): bool
    {
        return $this->role === self::ROLE_MEDECIN;
    }

    public function isSecretaire(): bool
    {
        return $this->role === self::ROLE_SECRETAIRE;
    }

    public function isPatient(): bool
    {
        return $this->role === self::ROLE_PATIENT;
    }

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