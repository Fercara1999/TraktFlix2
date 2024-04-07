function obtenPeliculasTrending() {
    fetch('/api/trending-movies')
        .then(response => response.json())
        .then(data => {
            var resultadoDiv = document.getElementById("resultado");
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
                peliculaDiv.innerHTML = '<img src="" alt="Poster de la película" style="width: 250px;">' +
                    '<p style="text-align: center;">'+pelicula['movie']['title']+'</p>';

                fetch('/api/movie-poster/' + pelicula['movie']['ids']['tmdb'])
                    .then(response => response.json())
                    .then(posterData => {
                        if (posterData && posterData['poster_path']) {
                            var posterImg = peliculaDiv.querySelector("img");
                            posterImg.src = 'https://image.tmdb.org/t/p/w500/' + posterData['poster_path'];
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

