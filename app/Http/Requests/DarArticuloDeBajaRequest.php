<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DarArticuloDeBajaRequest extends FormRequest
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
            "adjuntos" => "required|array",
            "adjuntos.*" => "required|mimes:jpeg,png,pdf|max:3000",
            "id" => "required|numeric|exists:articulos,id"
        ];
    }
}
