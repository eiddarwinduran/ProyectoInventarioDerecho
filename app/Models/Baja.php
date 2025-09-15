<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Baja extends Model
{
    use HasFactory;

    protected $table = 'bajas';
    protected $primaryKey = 'id_baja';

    protected $fillable = [
        'codigo',
        'fecha_baja',
        'estado',
        'descripcion',
    ];

    // Relación con equipos
    public function equipo()
    {
        return $this->belongsTo(Equipo::class, 'codigo', 'codigo');
    }
}

