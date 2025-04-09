<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Region extends Model
{
    use HasFactory;

    protected $fillable = ['code', 'name', 'currency_code'];


    public function services()
    {
        return $this->hasMany(Service::class);
    }

}
