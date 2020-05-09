@if(session("mensaje") && session("tipo"))
    <div class="notification is-{{session('tipo')}}">
        {{session('mensaje')}}
    </div>
@endif