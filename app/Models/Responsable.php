<?php
// app/Models/Responsable.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Responsable extends Model
{
    protected $table = 'responsables';
    protected $primaryKey = 'id_responsable';
    protected $fillable = ['nombre','apellido','ci','cargo','telefono','correo'];

     public function movimientos()
    {
        return $this->hasMany(Movimiento::class, 'ci', 'ci');
    }
}
