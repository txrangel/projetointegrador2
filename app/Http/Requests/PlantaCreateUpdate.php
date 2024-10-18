<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class PlantaCreateUpdate extends FormRequest
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
            'nome' => ['required', 'string', 'max:255',Rule::unique('plantas')->ignore($id)],
            'endereco' => ['required', 'string', 'max:255'],
            'cep' => ['required', 'string', 'max:8'],
            'maximo_carretas' => ['required', 'numeric'],
            'maximo_entregas' => ['required', 'numeric'],
            'qtd_entrega_padrao' => ['required', 'numeric'],
            'dias_da_semana' => ['array'], 
            'dias_da_semana.*' => ['exists:dias_da_semana,id'],  
        ];
    }
}
