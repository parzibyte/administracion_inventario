const convertir = () => {
    const fondoModal = document.querySelector(".modal-background");
    if (fondoModal) {
        fondoModal.style.backgroundColor = "transparent";
    }
    const cambiarFuente = elemento => {
        elemento.style.fontFamily = "Arial";
        elemento.style.fontSize = "1.1rem";
        elemento.style.color = "black";
    };
    const cosasDeTablas = document.querySelectorAll("td, th");
    if (cosasDeTablas) {
        cosasDeTablas.forEach(cosa => {
            cosa.style.border = "2px solid black"
        });
    }
    const cosasColoridas = document.querySelectorAll(".button,.textarea,.pagination-link,.pagination-next,.notification,input,.navbar,.modal-card-head,.modal-card-body,.modal-card-foot");
    if (cosasColoridas) {

        cosasColoridas.forEach(cosaColorida => {
            cosaColorida.style.backgroundColor = "white";
            cosaColorida.style.border = "2px solid black";
            cosaColorida.style.color = "black";
            cosaColorida.style.borderRadius = 0;
            cambiarFuente(cosaColorida);
        });
    }

    const titulos = document.querySelectorAll("h1,h2,h3,h4,h5,h6");
    if (titulos) {
        titulos.forEach(titulo => cambiarFuente(titulo));
    }


    const cosasConTexto = document.querySelectorAll("td,p");
    if (cosasConTexto) {
        cosasConTexto.forEach(cosa => {
            // mmm, si tiene un botón dentro, no hacemos nada
            if (!cosa.querySelector("button"))
                cosa.innerText = "texto";
            cambiarFuente(cosa);
        });
    }

    const elementosDelMenu = document.querySelectorAll("a.navbar-item");
    if (elementosDelMenu) {
        elementosDelMenu.forEach(elemento => {
            cambiarFuente(elemento);
            let posibleIcono = elemento.querySelector("i");
            if (posibleIcono) {
                posibleIcono.style.fontSize = "1.1rem";
                posibleIcono.style.color = "black";
            }
        })
    }
};