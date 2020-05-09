<?php

namespace App\Http\Controllers;

use App\Http\Requests\GuardarCambiosDeResponsableRequest;
use App\Http\Requests\GuardarResponsableRequest;
use Illuminate\Support\Facades\Config;
use App\Responsable;
use Illuminate\Http\Request;

class ResponsablesController extends Controller
{
    //
    public function agregar(GuardarResponsableRequest $peticion)
    {
        $datosDecodificados = json_decode($peticion->getContent());
        $responsable = new Responsable;
        $responsable->nombre = $datosDecodificados->nombre;
        $responsable->direccion = $datosDecodificados->direccion;
        $responsable->areas_id = $datosDecodificados->areas_id;
        return response()->json($responsable->save());
    }

    public function mostrar()
    {
        return Responsable::orderBy("updated_at", "desc")
            ->orderBy("created_at", "desc")
            ->with("area")
            ->paginate(Config::get("constantes.paginas_en_paginacion"));
    }

    public function guardarCambios(GuardarCambiosDeResponsableRequest $peticion)
    {
        $datosDecodificados = json_decode($peticion->getContent());
        $idResponsable = $datosDecodificados->id;
        $responsable = Responsable::findOrFail($idResponsable);
        $responsable->nombre = $datosDecodificados->nombre;
        $responsable->direccion = $datosDecodificados->direccion;
        $responsable->areas_id = $datosDecodificados->areas_id;
        return response()->json($responsable->save());

    }

    public function buscar(Request $peticion)
    {
        $busqueda = urldecode($peticion->busqueda);
        return Responsable::where("nombre", "like", "%$busqueda%")
            ->with("area")
            ->paginate(Config::get("constantes.paginas_en_paginacion"));
    }

    public function porId(Request $peticion)
    {
        $idResponsable = $peticion->id;
        $responsable = Responsable::where("id", "=", $idResponsable)->with("Area")->first();
        return response()->json($responsable);
    }

    public function eliminar($id)
    {
        $responsable = Responsable::find($id);
        $responsable->delete();
    }


    public function eliminarMuchos(Request $peticion)
    {
        $idsParaEliminar = json_decode($peticion->getContent());
        return Responsable::destroy($idsParaEliminar);
    }
}
