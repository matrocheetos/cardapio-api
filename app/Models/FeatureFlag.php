<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FeatureFlag extends Model
{
    protected $table = 'feature_flags';
    protected $primaryKey = 'id';
    protected $fillable = ['name', 'enabled'];
    public $timestamps = true;
}
