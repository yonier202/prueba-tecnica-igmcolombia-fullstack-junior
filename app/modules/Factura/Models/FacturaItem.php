<?php
namespace App\Modules\Factura\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FacturaItem extends Model
{
    use HasFactory;

    protected $fillable = ['factura_id', 'nombre', 'cantidad', 'iva', 'precio_unitario'];

    public function factura()
    {
        return $this->belongsTo(Factura::class);
    }
}

