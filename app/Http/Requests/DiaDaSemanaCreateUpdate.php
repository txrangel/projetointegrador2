<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class DiaDaSemanaCreateUpdate extends FormRequest
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
            'numero' => ['required','integer',Rule::unique('dias_da_semana')->ignore($id)],
            'nome' => ['required','string'],
            'horario_inicio' => ['required'],
            'horario_fim' => ['required'],
        ];
    }
}
