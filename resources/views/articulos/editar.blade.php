@extends("maestra")
@section("titulo", "Editar artículo")
@section("contenido")
    <div class="container" id="app">
        <div class="columns">
            <div class="column">
                <h1 class="is-size-1">Editar artículo</h1>
                <div class="field is-horizontal">
                    <div class="field-body">
                        <div class="field">
                            <label class="label">Fecha de adquisición</label>
                            <div class="control">
                                <input v-model="articulo.fechaAdquisicion" autocomplete="off" class="input" type="date">
                            </div>
                        </div>
                        <div class="field">
                            <label class="label">Código</label>
                            <div class="control">
                                <input placeholder="Código identificador" v-model="articulo.codigo" autocomplete="off"
                                       class="input" type="text">
                            </div>
                        </div>
                        <div class="field">
                            <label class="label">Número/folio de comprobante</label>
                            <div class="control">
                                <input placeholder="Folio o número" v-model="articulo.numeroFolioComprobante"
                                       autocomplete="off"
                                       class="input" type="text">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="columns">
                    <div class="column">
                        <div class="field">
                            <label class="label">Marca</label>
                            <div class="control">
                                <input placeholder="La marca del artículo" v-model="articulo.marca" autocomplete="off"
                                       class="input" type="text">
                            </div>
                        </div>
                        <div class="field">
                            <label class="label">Modelo</label>
                            <div class="control">
                                <input placeholder="El modelo del artículo" v-model="articulo.modelo" autocomplete="off"
                                       class="input" type="text">
                            </div>
                        </div>
                        <div class="field">
                            <label class="label">Serie</label>
                            <div class="control">
                                <input placeholder="Número de serie del artículo" v-model="articulo.serie"
                                       autocomplete="off" class="input" type="text">
                            </div>
                        </div>
                    </div>
                    <div class="column">
                        <div class="field">
                            <label class="label">Descripción</label>
                            <div class="control">
                                <textarea v-model="articulo.descripcion" placeholder="Describe el artículo" cols="30"
                                          rows="6" class="textarea"></textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <hr>
                <div class="columns">
                    <div class="column">
                        <div class="field is-horizontal">
                            <div class="field-body">
                                <div class="field">
                                    <label class="label">Estado</label>
                                    <div class="control">
                                        <div class="select is-fullwidth">
                                            <select v-model="articulo.estado">
                                                <option value="regular">Regular</option>
                                                <option value="malo">Malo</option>
                                                <option value="inservible">Inservible</option>
                                                <option value="noEncontrado">No encontrado físicamente</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="field">
                                    <label class="label">Costo de adquisición</label>
                                    <div class="control">
                                        <input placeholder="Precio de adquisición" v-model="articulo.costoAdquisicion"
                                               autocomplete="off"
                                               class="input" type="number">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <nav class="panel">
                            <div class="panel-block">
                                <p class="control">
                                    <label class="label">Área</label>
                                    <input @focus="mostrar.areas = true" v-model="busqueda"
                                           @keyup="buscarArea()" class="input" type="text"
                                           placeholder="Buscar área">
                                </p>
                            </div>
                            @verbatim
                                <a v-show="mostrar.areas && busqueda" @click="seleccionarArea(area)"
                                   v-for="area in areas"
                                   class="panel-block" :class="{'is-active': area.id === areaSeleccionada.id}">
                            <span class="panel-icon">
                                <i class="fas fa-building" aria-hidden="true"></i>
                            </span>
                                    {{area.nombre}}
                                </a>
                                <div v-show="areaSeleccionada.id" class="notification is-info">
                                    <h4 class="is-size-4">Área: {{areaSeleccionada.nombre}}</h4>
                                </div>
                        </nav>
                    </div>
                    <div class="column">
                        <div class="field">
                            <label class="label">Observaciones</label>
                            <div class="control">
                                <textarea v-model="articulo.observaciones"
                                          placeholder="Observaciones que el artículo tenga" cols="30"
                                          rows="4" class="textarea"></textarea>
                            </div>
                        </div>
                    </div>
                </div>

                <div v-show="errores.length > 0" class="notification is-danger">
                    <h5 class="is-size-5">Por favor, valida los siguientes errores:</h5>
                    <ul>
                        <li v-for="error in errores">
                            {{error}}
                        </li>
                    </ul>
                </div>
                <div v-show="mostrar.aviso" class="notification" :class="aviso.tipo">
                    {{aviso.mensaje}}
                </div>
                @endverbatim
                @include("errores")
                @include("notificacion")
                @verbatim
                    <button :class="{'is-loading':cargando}" @click="guardar()" class="button is-success">Guardar
                    </button>
                @endverbatim
                <a class="button is-primary" href="{{route("articulos")}}">Ver todos</a>
                <br>
            </div>
        </div>
    </div>
    <script src="{{url("/js/articulos/editar.js?q=") . time()}}"></script>
@endsection
