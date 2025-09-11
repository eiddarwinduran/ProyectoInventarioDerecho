<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Movimiento extends Model
{
    use HasFactory;

    protected $table = 'movimientos';
    protected $primaryKey = 'id_movimiento';
    public $timestamps = false; 

    protected $fillable = [
        'codigo',
        'ci',
        'id_ubicacion',
        'estado',
        'fecha_movimiento',
        'detalle'
    ];

    public function equipo()
    {
        return $this->belongsTo(Equipo::class, 'codigo', 'codigo');
    }

    public function responsable()
    {
        return $this->belongsTo(Responsable::class, 'ci', 'ci');
    }

    public function ubicacion()
    {
        return $this->belongsTo(Ubicacion::class, 'id_ubicacion', 'id_ubicacion');
    }
}
