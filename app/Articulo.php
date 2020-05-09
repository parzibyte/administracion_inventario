<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Articulo extends Model
{
    protected $table = "articulos";

    public function area()
    {
        return $this->belongsTo("App\Area", "areas_id");
    }

    public function fotos()
    {
        return $this->hasMany("App\FotoDeArticulo", "articulos_id");
    }
}
