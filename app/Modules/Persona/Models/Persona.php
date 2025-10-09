<?php
namespace App\Modules\Persona\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Persona extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombres',
        'apellidos',
        'tipo_documento',
        'documento',
        'email',
        'telefono',
    ];
}

