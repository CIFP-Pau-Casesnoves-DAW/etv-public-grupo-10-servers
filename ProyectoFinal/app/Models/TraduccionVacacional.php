<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TraduccionVacacional extends Model
{
    use HasFactory;

    protected $table='traduccionVacacional';
    protected $primaryKey=['tiposVacacionalId', 'idiomaId'];
    public $incrementing=false;
    public $timestamps=false;
    protected $fillable=['tiposVacacionalId', 'idiomaId', 'traduccion'];

}
