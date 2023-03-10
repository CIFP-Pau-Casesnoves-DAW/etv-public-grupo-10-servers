<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TraduccionServicios extends Model
{
    use HasFactory;

    protected $table='traduccionServicios';
    protected $primaryKey=['servicioId', 'idiomaId'];
    public $incrementing=false;
    public $timestamps=false;
    protected $fillable=['servicioId', 'idiomaId', 'traduccion'];
}
