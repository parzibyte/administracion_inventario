@extends("maestra")
@section("titulo", "Fotos de artículo")
@section("contenido")
    <div class="container" id="app">
        <div class="columns">
            <div class="column">
                <h1 class="is-size-1">Fotos de artículo ({{count($articulo->fotos)}})</h1>
            </div>
        </div>
        <div class="columns notification">
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
                    <form enctype="multipart/form-data" method="post" action="{{route("agregarFotosDeArticulo")}}">
                        <div class="file is-info has-name is-boxed">
                            <label class="file-label">
                                @csrf
                                <input type="hidden" name="id" value="{{$articulo->id}}">
                                <input accept="image/jpeg,image/png" ref="fotos" @change="onFotosCambiadas" multiple
                                       class="file-input" type="file" name="fotos[]">
                                <span class="file-cta">
                                    <span class="file-icon">
                                        <i class="fas fa-images"></i>
                                    </span>
                                    <span class="file-label">
                                        Seleccionar fotos
                                    </span>
                                </span>
                                @verbatim
                                    <span class="file-name" v-for="foto in fotos">
                                        {{foto.name}}
                                    </span>
                                @endverbatim
                            </label>
                        </div>
                        <div class="field"><br>
                            <button :disabled="fotos.length <= 0" class="button is-success" type="submit">Subir</button>
                        </div>

                    </form>
                </div>
                @include("errores")
                @include("notificacion")
            </div>
        </div>
        @php
            $mostrarPorFila = 3
        @endphp
        {{-- https://parzibyte.me/blog/2019/03/02/blade-laravel-ciclos-condicionales-token-csrf-componentes/ --}}
        @forelse($articulo->fotos as $foto)
            {{--
                Nota: los comentarios suponen que $mostrarPorFila es 3. Si no, igual funciona pero no entenderás los comentarios
            Abrir div si es elemento es 1, 4, 7, etcétera (comenzando a contar en 1)--}}
            @if($loop->iteration % $mostrarPorFila === 1)
                <div class="columns">
                    @endif
                    <div class="column">
                        <div class="card">
                            <div class="card-image">
                                <figure class="image is-4by3">
                                    <img src="{{route("fotoDeArticulo", ["nombre" => $foto->ruta])}}"
                                         alt="Placeholder image">
                                </figure>
                            </div>
                            <footer class="card-footer">
                                <a href="{{route("fotoDeArticulo", ["nombre" => $foto->ruta])}}" target="_blank"
                                   class="card-footer-item">Ampliar</a>
                                <a @click="eliminar('{{$foto->ruta}}')" class="card-footer-item">Eliminar</a>
                                <a href="{{route("descargarFotoDeArticulo", ["nombre" => $foto->ruta])}}"
                                   class="card-footer-item">Descargar</a>
                            </footer>
                        </div>
                    </div>
                    {{--
                        Cerrar el div. Ya sea porque llegamos al final y corrimos con la suerte de que el
                        arreglo tuviera una longitud múltipla de 3 ($loop->iteration % 3 === 0 && $loop->iteration !== 0)

                         O cerrarlo porque es el último elemento y la longitud no era múltiplo de 3
                         ($loop->last && $loop->count % 3 !== 0)
                    --}}
                    @if(($loop->iteration % $mostrarPorFila === 0 && $loop->iteration !== 0) || ($loop->last && $loop->count % $mostrarPorFila !== 0))
                </div>
            @endif
        @empty
            <div class="columns">
                <div class="column">
                    <h1 class="is-size-1">No hay fotos</h1>
                </div>
            </div>
        @endforelse
    </div>
    <script src="{{url("/js/articulos/fotos.js?q=") . time()}}"></script>
@endsection
