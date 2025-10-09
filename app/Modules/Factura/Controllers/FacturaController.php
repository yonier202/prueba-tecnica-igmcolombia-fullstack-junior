<?php
namespace App\Modules\Factura\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Factura\Models\Factura;
use App\Modules\Factura\Requests\FacturaRequest;
use App\Modules\Factura\Services\FacturaService;

class FacturaController extends Controller
{
    protected $service;

    public function __construct(FacturaService $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        return response()->json($this->service->list());
    }

    public function store(FacturaRequest $request)
    {
        $data = $request->validated();

        if ($request->hasFile('archivo_adjunto')) {
            $data['archivo_adjunto'] = $request->file('archivo_adjunto')->store('facturas');
        }

        $factura = $this->service->create($data);
        return response()->json($factura, 201);
    }

    public function update(FacturaRequest $request, Factura $factura)
    {
        $data = $request->validated();

        if ($request->hasFile('archivo_adjunto')) {
            $data['archivo_adjunto'] = $request->file('archivo_adjunto')->store('facturas');
        }

        $factura = $this->service->update($factura, $data);
        return response()->json($factura);
    }

    public function destroy(Factura $factura)
    {
        $this->service->delete($factura);
        return response()->json(['message' => 'Eliminada correctamente']);
    }
}


