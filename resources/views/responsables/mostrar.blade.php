@extends("maestra")
@section("titulo", "Responsables")
@section("contenido")
    <div id="app" class="container" v-cloak>
        <div class="columns">
            <div class="column">
                <div class="notification">
                    <div class="columns is-vcentered">
                        <div class="column">
                            @verbatim
                                <h4 class="is-size-4">Responsables ({{paginacion.total}})</h4>
                            @endverbatim
                        </div>
                        <div class="column">
                            <div class="field has-addons">
                                <div class="control">
                                    <input :readonly="deberiaDeshabilitarBusqueda" v-model="busqueda" @keyup="buscar()"
                                           class="input " type="text"
                                           placeholder="Buscar por nombre">
                                </div>
                                <div class="control">
                                    <button :disabled="deberiaDeshabilitarBusqueda || !busqueda" v-show="!this.busqueda"
                                            @click="buscar()" class="button is-info"
                                            :class="{'is-loading': buscando}">
                                            <span class="icon is-small">
                                              <i class="fa fa-search"></i>
                                            </span>
                                    </button>

                                    <button v-show="this.busqueda" @click="limpiarBusqueda()" class="button is-info"
                                            :class="{'is-loading': buscando}">
                                            <span class="icon is-small">
                                              <i class="fa fa-times"></i>
                                            </span>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="column">
                            <div class="field is-grouped is-pulled-right">
                                <div class="control">
                                    <a href="{{route("formularioAgregarResponsable")}}" class="button is-success">Agregar</a>
                                </div>
                                <div class="control">
                                    @verbatim
                                        <transition name="bounce">
                                            <button @click="eliminarMarcados()" v-show="numeroDeElementosMarcados > 0"
                                                    class="button is-warning"
                                                    :class="{'is-loading': cargando.eliminandoMuchos}">
                                                Eliminar ({{numeroDeElementosMarcados}})
                                            </button>
                                        </transition>
                                    @endverbatim
                                </div>
                            </div>
                            &nbsp;
                        </div>
                    </div>
                </div>
                <div v-show="cargando.lista" class="notification is-info has-text-centered">
                    <h3 class="is-size-3">Cargando</h3>
                    <div>
                        <h1 class="icono-gigante">
                            <i class="fas fa-spinner fa-spin"></i>
                        </h1>
                    </div>
                    <p class="is-size-5">
                        Por favor, espera un momento
                    </p>
                </div>
                <transition name="fade">
                    <div v-show="responsables.length <= 0 && !busqueda && !cargando.lista"
                         class="notification is-info has-text-centered">
                        <h3 class="is-size-3">Todavía no hay responsables</h3>
                        <div>
                            <h1 class="icono-gigante">
                                <i class="fas fa-box-open"></i>
                            </h1>
                        </div>
                        <p class="is-size-5">
                            Parece que no has agregado ninguna persona. Registra una haciendo click en el botón
                            <strong>Agregar</strong>
                        </p>
                    </div>
                </transition>
                <transition name="fade">
                    <div v-show="responsables.length <= 0 && busqueda && !cargando.lista"
                         class="notification is-warning has-text-centered">
                        <h3 class="is-size-3">No hay resultados</h3>
                        <div>
                            <h1 class="icono-gigante">
                                <i class="fas fa-search"></i>
                            </h1>
                        </div>
                        <p class="is-size-5">
                            No hay resultados que coincidan con tu búsqueda
                        </p>
                    </div>
                </transition>
                @include("errores")
                @include("notificacion")
                <div>

                    <table v-show="responsables.length > 0 && !cargando.lista"
                           class="table is-bordered is-striped is-hoverable is-fullwidth">
                        <thead>
                        <tr>
                            <th>
                                <button @click="onBotonParaMarcarClickeado()" class="button"
                                        :class="{'is-info': numeroDeElementosMarcados > 0}">
                                    <span class="icon is-small">
                                        <i class="fa fa-check"></i>
                                    </span>
                                </button>
                            </th>
                            <th>Área</th>
                            <th>Nombre</th>
                            <th>Dirección</th>
                            <th>Editar</th>
                            <th>Eliminar</th>
                        </tr>
                        </thead>
                        <tbody>
                        @verbatim
                            <tr v-for="responsable in responsables">
                                <td>
                                    <button @click="invertirEstado(responsable)" class="button"
                                            :class="{'is-info': responsable.marcado}">
                                    <span class="icon is-small">
                                        <i class="fa fa-check"></i>
                                    </span>
                                    </button>
                                </td>
                                <td>{{responsable.area.nombre}}</td>
                                <td>{{responsable.nombre}}</td>
                                <td>{{responsable.direccion}}</td>
                                <td>
                                    <button @click="editar(responsable)" class="button is-warning">
                                    <span class="icon is-small">
                                        <i class="fa fa-edit"></i>
                                    </span>
                                    </button>
                                </td>
                                <td>
                                    <button @click="eliminar(responsable)" class="button is-danger"
                                            :class="{'is-loading': responsable.eliminando}">
                                    <span class="icon is-small">
                                        <i class="fa fa-trash"></i>
                                    </span>
                                    </button>
                                </td>
                            </tr>
                        @endverbatim
                        </tbody>
                    </table>
                    <nav v-show="paginacion.ultima > 1" class="pagination" role="navigation" aria-label="pagination">
                        <a :disabled="!puedeRetrocederPaginacion()" @click="retrocederPaginacion()"
                           class="pagination-previous">Anterior</a>
                        <a :disabled="!puedeAvanzarPaginacion()" @click="avanzarPaginacion()" class="pagination-next">Siguiente
                            página</a>
                        @verbatim
                            <ul class="pagination-list">
                                <li v-for="pagina in paginas">
                                    <a v-if="!pagina.puntosSuspensivos" @click="irALaPagina(pagina.numero)"
                                       class="pagination-link"
                                       :class="{'is-current':pagina.numero === paginacion.actual}">{{pagina.numero}}</a>
                                    <span class="pagination-ellipsis" v-else>&hellip;</span>
                                </li>

                            </ul>
                        @endverbatim
                    </nav>
                </div>
            </div>
        </div>
    </div>
    <script src="{{url("/js/responsables/mostrar.js?q=") . time()}}"></script>
@endsection
