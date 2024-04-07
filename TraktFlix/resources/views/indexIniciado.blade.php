<?php
use Illuminate\Support\Facades\Auth;

?>

@extends('layouts.app')

@section('header')
<?php
    $nombreUsuario = Auth::user()->usuario;
    echo '<h1> Bienvenido ' .$nombreUsuario .'</h1>';

?>
@endsection

@section('main')

<main>

  <div id="resultadoTendencias"></div>

</main>

@endsection