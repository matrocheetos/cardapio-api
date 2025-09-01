<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Restaurante extends Model
{
    protected $table = 'restaurante';

    protected $primaryKey = 'id_restaurante';

    public $timestamps = true;
}
