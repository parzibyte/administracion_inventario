@extends("maestra")
@section("titulo", "Editar área")
@section("contenido")
    <div class="container">
        <div class="columns">
            <div class="column is-half-tablet">
                <h1 class="is-size-1">Editar área</h1>
                <form method="POST" action="{{route("guardarCambiosDeArea")}}">
                    @method("put")
                    @csrf
                    <input type="hidden" value="{{$area->id}}" name="id">
                    <div class="field">
                        <label class="label">Nombre</label>
                        <div class="control">
                            <input value="{{$area->nombre}}" autocomplete="off" name="nombre" class="input" type="text"
                                   placeholder="Nombre de área">
                        </div>
                    </div>
                    @include("errores")
                    @include("notificacion")
                    <button class="button is-success">Guardar</button>
                    <a class="button is-primary" href="{{route("areas")}}">Ver todas</a>
                </form>
                <br>
            </div>
        </div>
@endsection
