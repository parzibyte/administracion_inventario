@extends("maestra")
@section("titulo", "Dar de baja")
@section("contenido")
    <div class="container" id="app">
        <div class="columns">
            <div class="column">
                <h1 class="is-size-1">Dar de baja un artículo</h1>
            </div>
        </div>
        <div class="columns">
            <div class="column">
                <strong>{{$articulo->descripcion}}&nbsp;|
                    {{$articulo->marca}}&nbsp;|
                    {{$articulo->modelo}}&nbsp;|
                    {{$articulo->serie}}</strong>
                <br>
                <strong>Área: </strong> {{$articulo->area->nombre}}<br>
                <strong>Estado: </strong> {{$articulo->estado}}<br>
                <strong>Observaciones: </strong> {{$articulo->observaciones}}
            </div>
            <div class="column">
                <div class="field is-horizontal">
                    <form enctype="multipart/form-data" method="post" action="{{route("eliminarArticulo")}}">
                        <div class="file is-info has-name is-boxed">
                            <label class="file-label">
                                @csrf
                                <input type="hidden" name="id" value="{{$articulo->id}}">
                                <input accept="application/pdf,image/jpeg,image/png," ref="adjuntos"
                                       @change="onAdjuntosCambiados" multiple
                                       class="file-input" type="file" name="adjuntos[]">
                                <span class="file-cta">
                                    <span class="file-icon">
                                        <i class="fas fa-images"></i>
                                    </span>
                                    <span class="file-label">
                                        Seleccionar adjuntos
                                    </span>
                                </span>
                                @verbatim
                                    <span class="file-name" v-for="adjunto in adjuntos">
                                        {{adjunto.name}}
                                    </span>
                                @endverbatim
                            </label>
                        </div>
                        <div class="field"><br>
                            <button :disabled="adjuntos.length <= 0" class="button is-danger" type="submit">Dar de
                                baja
                            </button>
                        </div>
                    </form>
                </div>
                @include("errores")
                @include("notificacion")
            </div>
        </div>

    </div>
    <script src="{{url("/js/articulos/dar_de_baja.js?q=") . time()}}"></script>
@endsection
