<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Lista extends Model
{
    protected $table = 'listas';
    protected $primaryKey = 'lista_id';
    public $timestamps = true;
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'lista_id',
        'user_id',
        'nombre_lista',
        'descripcion',
        'activo'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}