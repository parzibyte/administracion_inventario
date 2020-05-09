<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class GuardarCambiosDeResponsableRequest extends FormRequest
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
            "nombre" => "required|max:255",
            "direccion" => "required|max:255",
            "id" => "required|numeric|exists:responsables,id",
            "areas_id" => "required|numeric|exists:areas,id",//Requerido y que exista en áreas, columna id :)
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
