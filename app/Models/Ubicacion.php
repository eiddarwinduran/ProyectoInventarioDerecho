<?php
// app/Models/Ubicacion.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ubicacion extends Model
{
    protected $table = 'ubicaciones';
    protected $primaryKey = 'id_ubicacion';
    protected $fillable = ['nombre_ubicacion','descripcion'];

    public function movimientos()
    {
        return $this->hasMany(Movimiento::class, 'id_ubicacion');
    }
}
