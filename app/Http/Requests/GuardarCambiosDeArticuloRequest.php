<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class GuardarCambiosDeArticuloRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            "id" => "required|numeric|exists:articulos,id",
            "fechaAdquisicion" => "required|date_format:Y-m-d",
            "codigo" => "required|max:255",
            "numeroFolioComprobante" => "max:255",
            "descripcion" => "required|max:255",
            "estado" => "required|in:regular,malo,inservible,noEncontrado",
            "observaciones" => "max:255",
            "costoAdquisicion" => "required|numeric|between:1,99999999.99",
            "areas_id" => "required|exists:areas,id",//Requerido y que exista en áreas, columna id :)
        ];
    }

    public function all($keys = null)
    {
        /*
         * Esto regresa un arreglo ya mapeado como si fuera un formulario. Por ejemplo, si
         * el objeto JSON es:
         * {
         *  nombre: "Luis",
         *  direccion: "New New York",
         * }
         *
         * Lo convierte a un array indexado por claves de string
         * [
         *  "nombre" => "Luis",
         *  "dreccion" => "New New York"
         * ]
         * */
        if (empty($keys)) {
            return parent::json()->all();
        }

        return collect(parent::json()->all())->only($keys)->toArray();
    }
}
