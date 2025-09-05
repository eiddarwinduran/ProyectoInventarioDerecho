<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Movimiento extends Model
{
    use HasFactory;

    protected $table = 'movimientos';
    protected $primaryKey = 'id_movimiento';
    public $timestamps = false; // ya que solo usas fecha_movimiento con default

    protected $fillable = [
        'codigo',
        'ci',
        'id_ubicacion',
        'fecha_movimiento',
        'detalle'
    ];

    // Relación con Equipo
    public function equipo()
    {
        return $this->belongsTo(Equipo::class, 'codigo', 'codigo');
    }

    // Relación con Responsable
    public function responsable()
    {
        return $this->belongsTo(Responsable::class, 'ci', 'ci');
    }

    // Relación con Ubicación
    public function ubicacion()
    {
        return $this->belongsTo(Ubicacion::class, 'id_ubicacion', 'id_ubicacion');
    }
}
