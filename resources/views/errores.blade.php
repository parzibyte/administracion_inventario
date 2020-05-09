@if(!empty($errors->all()))
    <div class="notification is-danger">
        <h4 class="is-size-4">Por favor, valida los siguientes errores:</h4>
        <ul>
            @foreach ($errors->all() as $mensaje)
                <li>
                    {{$mensaje}}
                </li>
            @endforeach
        </ul>
    </div>
@endif