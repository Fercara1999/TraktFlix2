@extends('layouts.app')

@section('main')

<button id="create-list-button">Crear lista</button>

<div id="create-list-modal" style="display: none;">
    <form action="{{ route('creaLista') }}" method="POST">
        @csrf
        <input type="text" id="nombre_lista" name="nombre_lista" placeholder="Ingrese el nombre de la lista">
        <input type="text" id="descripcion" name="descripcion" placeholder="Ingrese la descripción de la lista">
        <button id="confirm-button">Confirmar</button>
        <button id="cancel-button">Cancelar</button>
    </form>
</div>

<script>
    document.getElementById("create-list-button").addEventListener("click", function() {
        document.getElementById("create-list-modal").style.opacity = "0";
        document.getElementById("create-list-modal").style.display = "block";
        setTimeout(function() {
            document.getElementById("create-list-modal").style.opacity = "1";
        });
    });

    document.getElementById("confirm-button").addEventListener("click", function() {
        var name = document.getElementById("list-name").value;
        var description = document.getElementById("list-description").value;

        if (name) {
            console.log("Name: " + name);
            if (description) {
                console.log("Description: " + description);
            }
            // Realiza las acciones adicionales con el nombre y la descripción
        } else {
            console.log("User canceled or entered empty values");
        }

        document.getElementById("create-list-modal").style.opacity = "0";
        setTimeout(function() {
            document.getElementById("create-list-modal").style.display = "none";
        }, 2000);
    });

    document.getElementById("cancel-button").addEventListener("click", function() {
        console.log("User canceled");
        document.getElementById("create-list-modal").style.opacity = "0";
        setTimeout(function() {
            document.getElementById("create-list-modal").style.display = "none";
        }, 2000);
    });
</script>

<style>
    #create-list-modal {
        transition: opacity 2s;
    }
</style>

@endsection