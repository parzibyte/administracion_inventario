/*
 *     Copyright (C) 2019  Luis Cabrera Benito a.k.a. parzibyte
 *
 *     This program is free software: you can redistribute it and/or modify
 *     it under the terms of the GNU General Public License as published by
 *     the Free Software Foundation, either version 3 of the License, or
 *     (at your option) any later version.
 *
 *     This program is distributed in the hope that it will be useful,
 *     but WITHOUT ANY WARRANTY; without even the implied warranty of
 *     MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *     GNU General Public License for more details.
 *
 *     You should have received a copy of the GNU General Public License
 *     along with this program.  If not, see <https://www.gnu.org/licenses/>.
 */

const RUTA_EDITAR_ARTICULO = URL_BASE + "/articulos/editar",
    RUTA_FOTOS_ARTICULO = URL_BASE + "/articulos/fotos",
    RUTA_ELIMINAR_ARTICULO = URL_BASE + "/articulos/eliminar",
    RUTA_FOTO_MOSTRAR_ARTICULO = URL_BASE + "/foto/articulo",
    TARJETAS_MOSTRAR_POR_FILA = 2;
new Vue({
    el: "#app",
    data: () => ({
        buscando: false,
        articulos: [],
        gruposDeArticulos: [],
        numeroDeElementosMarcados: 0,
        rutaBaseFoto: RUTA_FOTO_MOSTRAR_ARTICULO,
        cargando: {
            eliminandoMuchos: false,
            lista: false,
            paginacion: false,
        },
        busqueda: "",
        paginacion: {
            total: 0,
            actual: 0,
            ultima: 0,
            siguientePagina: "",
            paginaAnterior: "",
        },
        paginas: [],
    }),
    beforeMount() {
        this.refrescarSinQueImporteBusquedaOPagina();
    },
    computed: {
        deberiaDeshabilitarBusqueda() {
            return this.articulos.length <= 0 && !this.busqueda;
        }
    },
    methods: {
        deberiaAbrirDiv(index) {
            let iteracion = index + 1;
            let resultado = iteracion % TARJETAS_MOSTRAR_POR_FILA === 1;
            console.log("Abrir?PAra %d regreso %s", index, resultado);
            return resultado;

        },
        deberiaCerrarDiv(index) {
            let iteracion = index + 1;
            let ultimo = iteracion === this.articulos.length;
            let resultado = (iteracion % TARJETAS_MOSTRAR_POR_FILA === 0 && iteracion !== 0) || (ultimo && this.articulos.length % TARJETAS_MOSTRAR_POR_FILA !== 0);
            console.log("Cerrar?PAra %d regreso %s", index, resultado);
            return resultado;
        },
        puedeAvanzarPaginacion() {
            return this.paginacion.actual < this.paginacion.ultima;
        },
        puedeRetrocederPaginacion() {
            return this.paginacion.actual > 1;
        },
        avanzarPaginacion() {
            if (this.puedeAvanzarPaginacion()) {
                this.irALaPagina(this.paginacion.actual + 1);
            }
        },
        retrocederPaginacion() {
            if (this.puedeRetrocederPaginacion()) {
                this.irALaPagina(this.paginacion.actual - 1);
            }
        },
        limpiarBusqueda() {
            this.busqueda = "";
            this.refrescarSinQueImporteBusquedaOPagina();
        },
        buscar: debounce(function () {
            if (this.busqueda && !this.buscando) {
                this.buscando = true;
                this.consultarArticulosConUrl(`/articulos/buscar/${encodeURIComponent(this.busqueda)}`)
                    .finally(() => this.buscando = false);
            } else {
                this.refrescarSinQueImporteBusquedaOPagina();
            }
        }, 500),
        editar(articulo) {
            window.location.href = `${RUTA_EDITAR_ARTICULO}/${articulo.id}`;
        },
        administrarFotos(articulo) {
            window.location.href = `${RUTA_FOTOS_ARTICULO}/${articulo.id}`;
        },
        eliminar(articulo) {
            window.location.href = `${RUTA_ELIMINAR_ARTICULO}/${articulo.id}`;
        },
        alternarMenu(articulo) {
            Vue.set(articulo, "mostrarMenu", !articulo.mostrarMenu);
        },
        ocultarMenu(articulo) {
            /*
            * Si se oculta inmediatamente cuando se selecciona una opción del menú, el
            * click de dicha opción no se dispara
            *
            * Si no se ocultara en el blur, se quedaría abierto cuando se hace click en otro lugar
            *
            * La solución es esperar 200 ms para ocultarlo, así, en caso de que se seleccione se
            * dispara el click. Y si no se selecciona, se oculta igualmente en 200 ms sin que el usuario
             * note esta espera ;)
            * */
            setTimeout(function () {
                Vue.set(articulo, "mostrarMenu", false);
            }, 200);
        },
        eliminarMarcados() {
            if (!confirm("¿Eliminar todos los elementos marcados?")) return;
            let arregloParaEliminar = this.articulos.filter(articulo => articulo.marcado).map(articulo => articulo.id);
            this.cargando.eliminandoMuchos = true;
            HTTP.post("/articulos/eliminar", arregloParaEliminar)
                .then(resultado => {

                })
                .finally(() => {
                    this.desmarcarTodos();
                    this.refrescarSinQueImporteBusquedaOPagina();
                    this.cargando.eliminandoMuchos = false;
                });
        },
        onBotonParaMarcarClickeado() {
            if (this.articulos.some(articulo => articulo.marcado)) {
                this.desmarcarTodos();
            } else {
                this.marcarTodos();
            }
        },
        marcarTodos() {
            this.numeroDeElementosMarcados = this.articulos.length;
            this.articulos.forEach(articulo => {
                Vue.set(articulo, "marcado", true);
            });
        },
        desmarcarTodos() {
            this.numeroDeElementosMarcados = 0;
            this.articulos.forEach(articulo => {
                Vue.set(articulo, "marcado", false);
            });
        },
        invertirEstado(articulo) {
            // Si está marcada, ahora estará desmarcada
            if (articulo.marcado) this.numeroDeElementosMarcados--;
            else this.numeroDeElementosMarcados++;
            Vue.set(articulo, "marcado", !articulo.marcado);
        },
        refrescarSinQueImporteBusquedaOPagina() {
            let url = this.busqueda ? `/articulos/buscar/${encodeURIComponent(this.busqueda)}?page=${this.paginacion.actual}` : "/articulos";
            this.consultarArticulosConUrl(url);
        },
        consultarArticulosConUrl(url) {
            this.desmarcarTodos();
            this.cargando.lista = true;
            return HTTP.get(url)
                .then(respuesta => {
                    // this.articulos = respuesta.data;
                    let articulos = [];
                    let longitud = respuesta.data.length;
                    for (let i = 0; i < longitud; i += TARJETAS_MOSTRAR_POR_FILA) {
                        articulos.push(respuesta.data.slice(i, i + TARJETAS_MOSTRAR_POR_FILA));
                    }
                    this.articulos = articulos;
                    console.log(this.gruposDeArticulos);
                    this.establecerPaginacion(respuesta);
                })
                .finally(() => this.cargando.lista = false);
        },
        establecerPaginacion(respuesta) {
            this.paginacion.siguientePagina = respuesta.next_page_url;
            this.paginacion.paginaAnterior = respuesta.prev_page_url;
            this.paginacion.actual = respuesta.current_page;
            this.paginacion.total = respuesta.total;
            this.paginacion.ultima = respuesta.last_page;
            this.prepararArregloParaPaginacion();
        },
        irALaPagina(pagina) {
            this.cargando.paginacion = true;
            this.consultarArticulosConUrl("/articulos?page=" + pagina).finally(() => this.cargando.paginacion = false);
        },
        prepararArregloParaPaginacion() {

            // Si no hay más de una página ¿Para qué mostrar algo?
            if (this.paginacion.ultima <= 1) return;
            this.paginas = [];
            // Poner la primera página
            this.paginas.push({numero: 1});
            // Izquierda de la actual
            let posibleIzquierdaDeActual = this.paginacion.actual - 1;
            if (posibleIzquierdaDeActual > 1 && posibleIzquierdaDeActual !== this.paginacion.ultima) {

                this.paginas.push({numero: posibleIzquierdaDeActual});
                // Si entre la izquierda de la actual y la primera hay un espacio grande, poner ...
                if (posibleIzquierdaDeActual - 1 > 1) this.paginas.splice(1, 0, {puntosSuspensivos: true})
            }
            // Poner la actual igualmente si no es la primera o última
            if (this.paginacion.actual !== 1 && this.paginacion.actual !== this.paginacion.ultima) {

                this.paginas.push({numero: this.paginacion.actual});
            }
            // Derecha de la actual
            let posibleDerechaDeActual = this.paginacion.actual + 1;
            if (posibleDerechaDeActual !== 1 && posibleDerechaDeActual < this.paginacion.ultima) {

                this.paginas.push({numero: posibleDerechaDeActual});
                // Si entre la derecha de la actual y la última hay un espacio grande, poner ...
                if (posibleDerechaDeActual + 1 < this.paginacion.ultima) this.paginas.push({puntosSuspensivos: true})
            }
            // Última
            this.paginas.push({numero: this.paginacion.ultima});
        }
    }
});