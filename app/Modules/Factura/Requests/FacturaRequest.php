<?php
namespace App\Modules\Factura\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FacturaRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'persona_id' => 'required|exists:personas,id',
            'numero_factura' => 'required|string|unique:facturas,numero_factura,' . $this->id,
            'descripcion' => 'nullable|string',
            'notas' => 'nullable|string',
            'fecha_emision' => 'required|date',
            'fecha_vencimiento' => 'required|date|after_or_equal:fecha_emision',
            'monto_total' => 'required|numeric|min:0',
            'estado' => 'required|in:pendiente,pagada,vencida',
            'archivo_adjunto' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'items' => 'required|array|min:1',
            'items.*.nombre' => 'required|string',
            'items.*.cantidad' => 'required|integer|min:1',
            'items.*.iva' => 'required|numeric|min:0',
            'items.*.precio_unitario' => 'required|numeric|min:0',
        ];
    }
}

