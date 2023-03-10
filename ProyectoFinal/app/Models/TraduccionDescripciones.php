<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TraduccionDescripciones extends Model
{
    use HasFactory;

    protected $table='traduccionDescripsciones';
    protected $primaryKey=['descripcioneId', 'idiomaId'];
    public $incrementing=false;
    public $timestamps=false;
    protected $fillable=['descripcioneId', 'idiomaId', 'traduccion'];
}
