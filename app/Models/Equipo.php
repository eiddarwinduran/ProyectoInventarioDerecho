<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Equipo extends Model
{
    protected $table = 'equipos';
    protected $primaryKey = 'id_equipo';
    protected $fillable = ['codigo', 'descripcion', 'id_comp'];

    public function componente()
    {
        return $this->belongsTo(Componente::class, 'id_comp');
    }
    public function movimientos()
    {
        return $this->hasMany(Movimiento::class, 'codigo', 'codigo');
    }
}
