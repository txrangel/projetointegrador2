<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DadoConsumoCreateUpdate extends FormRequest
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
        //$id = $this->route('id');
        return [
            'data_hora' => ['required', 'date'],
            'nivel' => ['required', 'numeric'],
            'tanque_id' => ['required', 'exists:tanques,id'],
        ];
    }
}
