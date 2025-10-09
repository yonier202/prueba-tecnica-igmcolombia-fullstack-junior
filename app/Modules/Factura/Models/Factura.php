<?php

namespace App\Modules\Factura\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Modules\Persona\Models\Persona;

class Factura extends Model
{
    use HasFactory;

    protected $fillable = [
        'persona_id',
        'numero_factura',
        'descripcion',
        'notas',
        'fecha_emision',
        'fecha_vencimiento',
        'monto_total',
        'estado',
        'archivo_adjunto',
    ];

    public function persona()
    {
        return $this->belongsTo(Persona::class);
    }

    public function items()
    {
        return $this->hasMany(FacturaItem::class);
    }
}


