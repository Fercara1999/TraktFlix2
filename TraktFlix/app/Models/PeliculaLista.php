<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PeliculaLista extends Model
{
    protected $table = 'peliculas_lista';
    protected $primaryKey = 'pelicula_lista_id';
    public $timestamps = true;
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'pelicula_lista_id',
        'lista_id',
        'trakt_id',
        'activo'
    ];

    public function lista()
    {
        return $this->belongsTo(Lista::class, 'lista_id');
    }
}