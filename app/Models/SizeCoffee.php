<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SizeCoffee extends Model
{
    protected $fillable = ['name','ml'];

    public function coffees()
    {
        return $this->hasMany(Coffee::class, 'size_id');
    }
}
