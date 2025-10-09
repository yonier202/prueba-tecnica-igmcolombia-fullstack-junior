<?php

namespace App\Modules\Persona\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Persona\Models\Persona;
use App\Modules\Persona\Requests\PersonaRequest;
use App\Modules\Persona\Services\PersonaService;
use Illuminate\Http\Request;

class PersonaController extends Controller
{
    protected $service;

    public function __construct(PersonaService $service)
    {
        $this->middleware('can:administrador');
        $this->service = $service;
    }

    public function index()
    {
        return response()->json($this->service->list());
    }

    public function store(PersonaRequest $request)
    {
        $persona = $this->service->create($request->validated());
        return response()->json($persona, 201);
    }

    public function findByDocumento(Request $request)
    {
        $persona = $this->service->findByDocumento(
            $request->tipo_documento,
            $request->numero_documento
        );

        if (!$persona) {
            return response()->json(['message' => 'Persona no encontrada'], 404);
        }

        return response()->json($persona);
    }

    public function update(PersonaRequest $request, Persona $persona)
    {
        $persona = $this->service->update($persona, $request->validated());
        return response()->json($persona);
    }

    public function destroy(Persona $persona)
    {
        $this->service->delete($persona);
        return response()->json(['message' => 'Eliminada correctamente']);
    }
}


