<?php

namespace App\Http\Controllers;

use App\Area;
use App\Http\Requests\GuardarArea;
use App\Http\Requests\GuardarCambiosDeArea;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Log;

class AreasController extends Controller
{
    //
    public function agregar(GuardarArea $peticion)
    {
        $area = new Area;
        $area->nombre = $peticion->nombre;
        $exitoso = $area->save();
        $mensaje = "Área agregada correctamente";
        $tipo = "success";
        if (!$exitoso) {
            $mensaje = "Error agregando área. Intente más tarde";
            $tipo = "danger";
        }
        return redirect()->route("formularioArea")
            ->with("mensaje", $mensaje)
            ->with("tipo", $tipo);
    }

    public function mostrar()
    {
        return Area::orderBy("updated_at", "desc")
            ->orderBy("created_at", "desc")
            ->paginate(Config::get("constantes.paginas_en_paginacion"));
    }

    public function buscar(Request $peticion)
    {
        $busqueda = urldecode($peticion->busqueda);
        return Area::where("nombre", "like", "%$busqueda%")
            ->paginate(Config::get("constantes.paginas_en_paginacion"));
    }

    public function editar(Request $peticion)
    {
        $idArea = $peticion->id;
        $area = Area::findOrFail($idArea);
        return view("editar_area", [
            "area" => $area,
        ]);
    }

    public function eliminar($id)
    {
        $area = Area::find($id);
        $area->delete();
    }

    public function guardarCambios(GuardarCambiosDeArea $peticion)
    {
        $idArea = $peticion->input("id");
        $area = Area::findOrFail($idArea);
        $area->nombre = $peticion->input("nombre");
        $area->save();
        return redirect()->route("areas")->with(["mensaje" => "Área editada correctamente", "tipo" => "success"]);

    }

    public function eliminarMuchas(Request $peticion)
    {
        $idsParaEliminar = json_decode($peticion->getContent());
        return Area::destroy($idsParaEliminar);
    }
}
