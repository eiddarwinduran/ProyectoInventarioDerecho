<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Componente extends Model
{
    protected $table = 'componentes';
    protected $primaryKey = 'id_comp';
    public $timestamps = false; 

    protected $fillable = [
        'procesador',
        'tarjeta_madre',
        'ram',
        'disco_duro',
        'tarjeta_video',
        'tarjeta_red',
    ];

    public function equipo()
    {
        return $this->hasOne(Equipo::class, 'id_comp');
    }
}
