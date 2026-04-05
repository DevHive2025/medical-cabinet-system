<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model; 
use Illuminate\Database\Eloquent\Factories\HasFactory;
class Secretaire extends Model
{
    use HasFactory;
    protected $fillable = ['user_id', 'bureau']; 

    public function user() {
        return $this->belongsTo(User::class);
    }
}
?>