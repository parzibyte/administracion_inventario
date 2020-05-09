<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Responsable extends Model
{

    public function area()
    {
        return $this->belongsTo("App\Area", "areas_id");
    }
}
