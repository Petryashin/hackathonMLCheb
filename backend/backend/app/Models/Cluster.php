<?php

namespace App\Models;
use App\Casts\Json;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cluster extends Model
{
    use HasFactory;
    protected $table = "clusters";
    protected $primaryKey = "id";
    protected $guarded = false;
    protected $casts = [
        'ids_clusters' => Json::class
    ];
    protected $hidden =["ids_clusters","created_at","updated_at"];
}
