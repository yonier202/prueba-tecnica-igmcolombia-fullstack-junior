<?php
namespace App\Modules\Factura\Services;

use App\Modules\Factura\Models\Factura;
use App\Modules\Factura\Models\FacturaItem;
use Illuminate\Support\Facades\DB;

class FacturaService
{
    public function list()
    {
        return Factura::with(['persona', 'items'])->paginate(10);
    }

    public function create(array $data)
    {
        return DB::transaction(function () use ($data) {
            $factura = Factura::create($data);

            if (isset($data['items'])) {
                foreach ($data['items'] as $item) {
                    $factura->items()->create($item);
                }
            }

            return $factura->load('items');
        });
    }

    public function update(Factura $factura, array $data)
    {
        $factura->update($data);
        $factura->items()->delete();

        if (isset($data['items'])) {
            foreach ($data['items'] as $item) {
                $factura->items()->create($item);
            }
        }

        return $factura->load('items');
    }

    public function delete(Factura $factura)
    {
        $factura->items()->delete();
        $factura->delete();
    }
}

