<?php
namespace App\Modules\Persona\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PersonaRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'nombres' => 'required|string|max:255',
            'apellidos' => 'required|string|max:255',
            'tipo_documento' => 'required|string|max:10',
            'documento' => 'required|string|max:20|unique:personas,documento,' . $this->id,
            'email' => 'nullable|email',
            'telefono' => 'nullable|string|max:20',
        ];
    }
}


