<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TraduccionTiposAlojamientos extends Model
{
    use HasFactory;

    protected $table='traduccionTiposalojamientos';
    protected $primaryKey=['tiposAlojameintosId', 'idiomaId'];
    public $incrementing=false;
    public $timestamps=false;
    protected $fillable=['tiposAlojameintosId', 'idiomaId', 'traduccion'];
}
