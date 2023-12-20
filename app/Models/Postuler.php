<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @method static findOrFail(string $id)
 */
class Postuler extends Model
{
    use HasFactory;
    protected $fillable =
        [
          'user_id',
          'referentiel_id',
          'status'
        ];

    public function referentiels()
    {
        return $this->belongsTo("Referentiel::class");
    }
    public function users()
    {
        return $this->belongsTo("User::class");
    }
}
