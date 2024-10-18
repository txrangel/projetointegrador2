<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class TanqueCreateUpdate extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $id = $this->route('id');
        return [
            'planta_id' => ['required','exists:plantas,id'],
            'maximo' => ['required','numeric'],
            'minimo' => ['required','numeric'],
            'unidade_de_medida_id' => ['required','exists:unidades_de_medidas,id'],
            'id_externo' => ['required','string',Rule::unique('tanques','id_externo')->ignore($id)],
        ];
    }
}
