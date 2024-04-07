<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PeliculaFavorita extends Model
{
    protected $table = 'peliculas_favoritas';
    protected $primaryKey = 'pelicula_favorita_id';
    public $timestamps = false;
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'pelicula_favorita_id',
        'user_id',
        'trakt_id',
        'activo',
    ];

    // Relación con el modelo User
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}