<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Area extends Model
{
    protected $table = "areas";

    public function responsable()
    {
        return $this->hasOne("App\Responsable", "id");
    }
}
