if (document.getElementById("resultadoTendencias")) {
    obtenPeliculasTrending();
}

if (document.getElementById("resultadoDatosPelicula")) {
    obtenDatosPelicula();
}

if (document.getElementById("resultadoBusqueda")) {
    obtenResultadoBusqueda();
}

// Obtiene las películas que se van a establecer como películas en tendencia
function obtenPeliculasTrending() {
    fetch('/api/trending-movies')
        .then(response => response.json())
        .then(data => {
            var resultadoDiv = document.getElementById("resultadoTendencias");
            resultadoDiv.innerHTML = '';

            var rowDiv;
            var count = 0;

            data.forEach(function (pelicula) {
                if (count % 5 === 0) {
                    rowDiv = document.createElement("div");
                    rowDiv.className = "row";
                    resultadoDiv.appendChild(rowDiv);
                }

                var peliculaDiv = document.createElement("div");
                peliculaDiv.className = "col";

                var peliculaLink = document.createElement("a");
                peliculaLink.href = `/detallePelicula?id=${pelicula['movie']['ids']['tmdb']}`;
                peliculaLink.innerHTML = '<img src="" alt="Poster de la película" style="width: 250px; display: block; margin: 0 auto;">' +
                    '<p style="text-align: center; color: white;">'+pelicula['movie']['title']+'</p>';

                peliculaDiv.appendChild(peliculaLink);

                fetch('/api/movie-poster/' + pelicula['movie']['ids']['tmdb'])
                    .then(response => response.json())
                    .then(posterData => {
                        if (posterData && posterData['poster_path']) {
                            var posterImg = peliculaLink.querySelector("img");
                            posterImg.src = 'https://image.tmdb.org/t/p/original/' + posterData['poster_path'];
                        } else {
                            console.error('No se pudo obtener la ruta del póster de la película');
                        }
                    })
                    .catch(error => {
                        console.error(error);
                    });

                rowDiv.appendChild(peliculaDiv);
                count++;
            });
        })
        .catch(error => {
            console.error(error);
        });
}

// Obtiene la key del trailer que se añadira a la URL de youtube
async function obtenerKeyTrailer(idPelicula) {
    try {
        const response = await fetch(`/api/trailer/${idPelicula}`);
        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }
        const data = await response.json();
        return data['results']['0']['key'];
    } catch (error) {
        console.error('Error:', error);
        return null;
    }
}

// Obtiene los datos de cada película
async function obtenDatosPelicula() {
    var urlParams = new URLSearchParams(window.location.search);
    var idPelicula = urlParams.get('id');

    const claveTrailer = await obtenerKeyTrailer(idPelicula);

    fetch('/api/datos-pelicula/' + idPelicula)
        .then(response => response.json())
        .then(data => {
            var resultadoDiv = document.getElementById("resultadoDatosPelicula");
            resultadoDiv.innerHTML = '';
            var peliculaDiv = document.createElement("div");
            peliculaDiv.id = "datosPelicula";
            peliculaDiv.style.display = "flex";
            peliculaDiv.style.alignItems = "center";
            peliculaDiv.style.justifyContent = "center";
            peliculaDiv.style.padding = "100px";
            peliculaDiv.style.paddingBottom = "0";
            peliculaDiv.style.backgroundImage = `url('https://image.tmdb.org/t/p/original/${data['backdrop_path']}')`;
            peliculaDiv.style.backgroundSize = "cover";
            peliculaDiv.style.backgroundPosition = "center";
            peliculaDiv.innerHTML = '<div style="text-align: center;">' +
                '<h1>' + data['original_title'] + '</h1>' +
                '<img src="" alt="Poster de la película" style="width: 250px;">' +
                '</div>' +
                '<div style="margin-left: 20px;" id="derechaDatosPeliculas">' +
                '<p style="color: white;"><strong>Resumen:</strong> ' + data['overview'] + '</p>' +
                '<p style="color: white;"><strong>Fecha de lanzamiento:</strong> ' + data['release_date'] + '</p>' +
                '<p style="color: white;"><strong>Rating:</strong> ' + data['vote_average'] + '</p>' +
                '<p style="color: white;"><strong>Duración:</strong> ' + data['runtime'] + ' minutos</p>' +
                '<p style="color: white;"><strong>Trailer:</strong> <a href="https://www.youtube.com/watch?v=' + claveTrailer + '" target="_blank">Ver trailer</a></p>' +
                '<button style="margin-right: 10px;" class="btn btn-primary" onclick="mostrarDialogoListas()">Añadir a lista</button>' +
                '<button style="margin-right: 10px;" class="btn btn-primary">Marcar como vista</button>' +
                '<button class="btn btn-primary" onclick="anadeFavoritas()">Añadir como favorita</button>' +
                '</div>';

            fetch('/api/movie-poster/' + idPelicula)
                .then(response => response.json())
                .then(posterData => {
                    if (posterData && posterData['poster_path']) {
                        var posterImg = peliculaDiv.querySelector("img");
                        posterImg.src = 'https://image.tmdb.org/t/p/original/' + posterData['poster_path'];
                    } else {
                        console.error('No se pudo obtener la ruta del póster de la película');
                    }
                })
                .catch(error => {
                    console.error(error);
                });

            resultadoDiv.appendChild(peliculaDiv);

            fetch('api/creditos-pelicula/' + idPelicula)
                .then(response => response.json())
                .then(data => {
                    var resultadoDiv = document.getElementById("resultadoDatosPelicula");
                    var creditosDiv = document.createElement("div");
                    creditosDiv.style.padding = "100px";
                    creditosDiv.style.paddingTop = "50px";
                    creditosDiv.style.paddingBottom = "50px";
                    var actores = data['cast'];
                    var actoresDiv = document.createElement("div");
                    actoresDiv.innerHTML = '<h3>Actores</h3>';
                    var sliderDiv = document.createElement("div");
                    sliderDiv.className = "slider";
                    sliderDiv.style.display = "flex";
                    sliderDiv.style.overflowX = "auto";
                    sliderDiv.style.scrollBehavior = "smooth";
                    var sliderContentDiv = document.createElement("div");
                    sliderContentDiv.style.display = "flex";
                    sliderContentDiv.style.gap = "25px";
                    actores.forEach(function (actor) {
                        var actorDiv = document.createElement("div");
                        actorDiv.style.marginRight = "25px";
                        actorDiv.style.textAlign = "center";
                        var actorImg = document.createElement("img");
                        actorImg.src = 'https://image.tmdb.org/t/p/original/' + actor['profile_path'];
                        actorImg.style.width = '100px';
                        actorDiv.appendChild(actorImg);
                        actorDiv.appendChild(document.createElement("br"));
                        var actorName = document.createElement("strong");
                        actorName.textContent = actor['name'];
                        actorDiv.appendChild(actorName);
                        actorDiv.appendChild(document.createElement("br"));
                        var characterName = document.createElement("span");
                        characterName.style.fontSize = "smaller";
                        characterName.textContent = actor['character'];
                        actorDiv.appendChild(characterName);
                        sliderContentDiv.appendChild(actorDiv);
                    });
                    sliderDiv.appendChild(sliderContentDiv);
                    actoresDiv.appendChild(sliderDiv);

                    var directores = data['crew'].filter(function (miembro) {
                        return miembro['job'] === 'Director';
                    });
                    var directoresDiv = document.createElement("div");
                    directoresDiv.style.paddingTop = "25px";
                    directoresDiv.innerHTML = '<h3>Director/es</h3>';
                    directores.forEach(function (director) {
                        var directorDiv = document.createElement("div");
                        directorDiv.style.textAlign = "center";
                        var directorImg = document.createElement("img");
                        directorImg.src = 'https://image.tmdb.org/t/p/original/' + director['profile_path'];
                        directorImg.style.width = '100px';
                        directorDiv.appendChild(directorImg);
                        directorDiv.appendChild(document.createElement("br"));
                        var directorName = document.createElement("strong");
                        directorName.textContent = director['name'];
                        directorDiv.appendChild(directorName);
                        directoresDiv.appendChild(directorDiv);
                    });

                    creditosDiv.appendChild(actoresDiv);
                    creditosDiv.appendChild(directoresDiv);
                    resultadoDiv.appendChild(creditosDiv);
                })
                .catch(error => {
                    console.error(error);
                });
        })
        .catch(error => {
            console.error(error);
        });

}

// Función para el buscador
function obtenResultadoBusqueda() {
    var urlParams = new URLSearchParams(window.location.search);
    var busqueda = urlParams.get('busqueda');
    
    fetch('/api/busca-peliculas/' + busqueda)
        .then(response => response.json())
        .then(data => {
            var resultadoDiv = document.getElementById("resultadoBusqueda");
            resultadoDiv.innerHTML = '';
            var rowDiv;
            var count = 0;
            var peliculas = data.results;
            peliculas.forEach(function (pelicula) {
                if (count % 5 === 0) {
                    rowDiv = document.createElement("div");
                    rowDiv.className = "row";
                    resultadoDiv.appendChild(rowDiv);
                }
                var peliculaDiv = document.createElement("div");
                peliculaDiv.className = "col";
                var peliculaLink = document.createElement("a");
                peliculaLink.href = `/detallePelicula?id=${pelicula['id']}`;
                peliculaLink.innerHTML = '<img src="" alt="Poster no disponible" style="width: 250px; display: block; margin: 0 auto; color: red;">' +
                    '<p style="text-align: center; color: white;">'+pelicula['original_title']+'</p>';
                peliculaDiv.appendChild(peliculaLink);
                fetch('/api/movie-poster/' + pelicula['id'])
                    .then(response => response.json())
                    .then(posterData => {
                        if (posterData && posterData['poster_path']) {
                            var posterImg = peliculaLink.querySelector("img");
                            posterImg.src = 'https://image.tmdb.org/t/p/original/' + posterData['poster_path'];
                        } else {
                            peliculaDiv.remove();
                        }
                    })
                    .catch(error => {
                        console.error(error);
                    });
                rowDiv.appendChild(peliculaDiv);
                count++;
            });
        })
        .catch(error => {
            console.error(error);
        });
}

// Muestra un cuadro de dialogo con cada lista que tiene ese usuario
function mostrarDialogoListas() {
    fetch('/listasUsuario')
        .then(response => response.json())
        .then(data => {
            var overlayDiv = document.createElement("div");
            overlayDiv.style.position = "fixed";
            overlayDiv.style.top = "0";
            overlayDiv.style.left = "0";
            overlayDiv.style.width = "100%";
            overlayDiv.style.height = "100%";
            overlayDiv.style.background = "rgba(0, 0, 0, 0.5)";
            overlayDiv.style.zIndex = "999";
            document.body.appendChild(overlayDiv);

            var dialogoDiv = document.createElement("div");
            dialogoDiv.style.position = "fixed";
            dialogoDiv.style.top = "50%";
            dialogoDiv.style.left = "50%";
            dialogoDiv.style.transform = "translate(-50%, -50%)";
            dialogoDiv.style.background = "rgba(30, 30, 30, 0.9)";
            dialogoDiv.style.padding = "20px";
            dialogoDiv.style.borderRadius = "5px";
            dialogoDiv.style.boxShadow = "0 2px 4px rgba(0, 0, 0, 0.2)";
            dialogoDiv.style.zIndex = "1000";
            dialogoDiv.style.color = "white";

            var tituloDiv = document.createElement("div");
            tituloDiv.innerHTML = "<h3 style='color: white;'>Selecciona una lista:</h3>";
            dialogoDiv.appendChild(tituloDiv);

            var promises = [];

            data.listas.forEach(function (lista) {
                var listaDiv = document.createElement("div");
                listaDiv.style.display = "flex";
                listaDiv.style.alignItems = "center";
                listaDiv.style.marginBottom = "10px";
            
                var checkbox = document.createElement("input");
                checkbox.type = "checkbox";
                checkbox.name = "listas";
                checkbox.value = lista.lista_id;
            
                listaDiv.appendChild(checkbox);
            
                var label = document.createElement("label");
                label.innerHTML = lista.nombre_lista;
                label.style.paddingLeft = "10px";
                label.addEventListener("click", function() {
                    checkbox.checked = !checkbox.checked;
                });
                listaDiv.appendChild(label);
            
                dialogoDiv.appendChild(listaDiv);
            
                var idPelicula = new URLSearchParams(window.location.search).get('id');
            
                var promise = fetch('/compruebaCheck/' + lista.lista_id + '/' + idPelicula)
                    .then(response => response.json())
                    .then(checkData => {
                        if (checkData) {
                            checkbox.checked = true;
                        }
                    })
                    .catch(error => {
                        console.error(error);
                    });
            
                promises.push(promise);
            });            

            Promise.all(promises)
                .then(() => {
                    var botonDiv = document.createElement("div");
                    botonDiv.style.marginTop = "20px";

                    var botonAceptar = document.createElement("button");
                    botonAceptar.className = "btn btn-primary";
                    botonAceptar.innerHTML = "Aceptar";
                    botonAceptar.onclick = function () {
                        var checkboxes = document.getElementsByName("listas");
                        var listasSeleccionadas = [];
                        var listasNoSeleccionadas = [];
                        checkboxes.forEach(function (checkbox) {
                            if (checkbox.checked) {
                                listasSeleccionadas.push(checkbox.value);
                            }else{
                                listasNoSeleccionadas.push(checkbox.value);
                            }
                        });
                        if (listasSeleccionadas.length > 0) {
                            listasSeleccionadas.forEach(function (lista) {
                                anadeLista(lista);
                            });
                        }
                        if (listasNoSeleccionadas.length > 0) {
                            listasNoSeleccionadas.forEach(function (lista) {
                                eliminaLista(lista);
                            });
                        }
                        dialogoDiv.remove();
                        overlayDiv.remove();
                    };
                    botonDiv.appendChild(botonAceptar);

                    var botonCancelar = document.createElement("button");
                    botonCancelar.className = "btn btn-secondary";
                    botonCancelar.innerHTML = "Cancelar";
                    botonCancelar.onclick = function () {
                        dialogoDiv.remove();
                        overlayDiv.remove();
                    };
                    botonDiv.appendChild(botonCancelar);

                    dialogoDiv.appendChild(botonDiv);

                    document.body.appendChild(dialogoDiv);
                })
                .catch(error => {
                    console.error(error);
                });
        })
        .catch(error => {
            console.error(error);
        });
}

// Añade la película a la lista seleccionada
function anadeLista(listasSeleccionadas) {
    var urlParams = new URLSearchParams(window.location.search);
    var idPelicula = urlParams.get('id');

    fetch('/nombreLista/' + listasSeleccionadas)
        .then(response => response.json())
        .then(data => {
            var nombreLista = data.nombre_lista;

            var csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

            fetch('/anadePeliculaLista', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken
                },
                body: JSON.stringify({
                    trakt_id: idPelicula,
                    lista_id: listasSeleccionadas
                })

            })
            .then(response => {
                console.log(idPelicula);
                console.log(listasSeleccionadas);
                if (response.ok) {
                    console.log('Película añadida a la lista "' + nombreLista + '" correctamente');
                } else {
                    alert('Error al añadir la película a la(s) lista(s)');
                }
            })
            .catch(error => {
                console.error(error);
            });
        })
        .catch(error => {
            console.error(error);
        });
}

function eliminaLista(listasNoSeleccionadas) {
    var urlParams = new URLSearchParams(window.location.search);
    var idPelicula = urlParams.get('id');

    fetch('/nombreLista/' + listasNoSeleccionadas)
        .then(response => response.json())
        .then(data => {
            var nombreLista = data.nombre_lista;

            var csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

            fetch('/desactivaPeliculaLista', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken
                },
                body: JSON.stringify({
                    trakt_id: idPelicula,
                    lista_id: listasNoSeleccionadas
                })
            })
            .then(response => {
                console.log(idPelicula);
                console.log(listasNoSeleccionadas);
                if (response.ok) {
                    console.log('Película eliminada de la lista "' + nombreLista + '" correctamente');
                } else {
                    alert('Error al eliminar la película de la(s) lista(s)');
                }
            })
            .catch(error => {
                console.error(error);
            });
        })
        .catch(error => {
            console.error(error);
        });
}

function anadeFavoritas(){
    var urlParams = new URLSearchParams(window.location.search);
    var idPelicula = urlParams.get('id');

    fetch('/anadeFavoritas', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({
            trakt_id: idPelicula
        })
    })
    .then(response => {
        if (response.ok) {
            console.log('Película añadida a favoritas correctamente');
        } else {
            alert('Error al añadir la película a favoritas');
        }
    })
    .catch(error => {
        console.error(error);
    });
}