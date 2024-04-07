<?php

namespace App\Models;

use App\Models\Post;
use Illuminate\Foundation\Auth\User as Authenticatable;


class User extends Authenticatable
{
    protected $table = 'users';
    protected $primaryKey = 'user_id';
    public $timestamps = true;
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'user_id',
        'nombre',
        'email',
        'password',
        'fecha_registro',
        'fecha_nacimiento',
        'usuario',
        'activo',
    ];


    public function posts()
    {
        return $this->hasMany(Post::class);
    }

    public function listas()
    {
        $listas = $this->hasMany(Lista::class, 'user_id');
        return $listas;
    }
}