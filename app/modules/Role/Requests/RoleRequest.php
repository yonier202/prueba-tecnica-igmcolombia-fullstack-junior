<?php

namespace App\Modules\Role\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RoleRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->can('administrador');
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255|unique:roles,name,' . ($this->role->id ?? 'null'),
            'permissions' => 'array|nullable',
            'permissions.*' => 'string'
        ];
    }
}
