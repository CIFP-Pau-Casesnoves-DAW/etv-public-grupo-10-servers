<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AlojamientosServicios extends Model
{
    use HasFactory;
    protected $table='alojamientoServicios';
    protected $primaryKey=['alojamientoId', 'servicioId'];
    public $incrementing=false;
    public $timestamps=false;
    protected $fillable=['alojamientoId','servicioId'];
}
