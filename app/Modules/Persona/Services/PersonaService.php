<?php
namespace App\Modules\Persona\Services;

use App\Modules\Persona\Models\Persona;

class PersonaService
{
    public function list($search = null)
    {
        return Persona::when($search, function ($query, $search) {
            $query->where('nombres', 'like', "%$search%")
                  ->orWhere('apellidos', 'like', "%$search%")
                  ->orWhere('documento', 'like', "%$search%");
        })->orderBy('id', 'desc')->paginate(10);
    }

    public function findByDocumento($tipo, $numero)
    {
        return Persona::where('tipo_documento', $tipo)
                      ->where('documento', $numero)
                      ->first();
    }

    public function create(array $data)
    {
        return Persona::create($data);
    }

    public function update(Persona $persona, array $data)
    {
        $persona->update($data);
        return $persona;
    }

    public function delete(Persona $persona)
    {
        return $persona->delete();
    }
}

