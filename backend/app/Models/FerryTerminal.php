<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FerryTerminal extends Model
{
    use HasFactory;

    protected $fillable = ['slug', 'name', 'latitude', 'longitude', 'description'];

    public function places()
    {
        return $this->hasMany(Place::class);
    }
}
