<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @method static create(array $array)
 */
class Referentiel extends Model
{
    use HasFactory;

   protected $fillable = [
       'nom_referentiel',
       'description',
       'echeance'
   ];
   public function users (): \Illuminate\Database\Eloquent\Relations\HasMany
   {
       return $this->hasMany(User::class);
   }
}
