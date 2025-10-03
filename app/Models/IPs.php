<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IPs extends Model
{
    use HasFactory;

    protected $table = 'ips';
    protected $primaryKey = 'id_ip';
    public $timestamps = false; 

    protected $fillable = [
        'codigo',
        'id_ubicacion',
        'ip',
        'mac',
        'subred',
        'gateway',
        'puerto',
        'switch'
    ];

    public function equipo()
    {
        return $this->belongsTo(Equipo::class, 'codigo', 'codigo');
    }
    public function ubicacion()
    {
        return $this->belongsTo(Ubicacion::class, 'id_ubicacion', 'id_ubicacion');
    }
}
