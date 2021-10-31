<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OpenStreetMap extends Model
{
    use HasFactory;

    protected $primaryKey = "id";
    protected $guarded = false;
    
}
