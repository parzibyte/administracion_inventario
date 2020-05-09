@extends("maestra")
@section("titulo", "Editar responsable")
@section("contenido")
    <div class="container" id="app">
        <div class="columns">
            <div class="column is-half-tablet">
                <h1 class="is-size-1">Editar responsable</h1>
                <div class="field">
                    <label class="label">Nombre completo</label>
                    <div class="control">
                        <input v-model="responsable.nombre" autocomplete="off" name="nombre" class="input" type="text"
                               placeholder="Nombre del responsable">
                    </div>
                </div>
                <div class="field">
                    <label class="label">Dirección</label>
                    <div class="control">
                            <textarea v-model="responsable.direccion" class="textarea"
                                      placeholder="Dirección del responsable" name="direccion"
                                      id="direccion" cols="30" rows="3"></textarea>
                    </div>
                </div>
                <nav class="panel">
                    <div class="panel-block">
                        <p class="control">
                            <label class="label">Área</label>
                            <input @focus="mostrar.areas = true" v-model="busqueda"
                                   @keyup="buscarArea()" class="input is-loading" type="text"
                                   placeholder="Buscar área">
                        </p>
                    </div>
                    @verbatim
                        <a v-show="mostrar.areas && busqueda" @click="seleccionarArea(area)" v-for="area in areas"
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
                <a class="button is-primary" href="{{route("responsables")}}">Ver todos</a>
                <br>
            </div>
        </div>
    </div>
    <script src="{{url("/js/responsables/editar.js?q=") . time()}}"></script>
@endsection
