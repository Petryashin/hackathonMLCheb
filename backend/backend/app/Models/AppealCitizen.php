<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AppealCitizen extends Model
{
    use HasFactory;
    public const KEYS_CATEGORIES = [
        'General improvement' => 'Общее благоустройство',
        'Major overhaul' => 'Капитальный ремонт в доме',
        'Need for a road' => 'Необходимость дороги/тротуара',
        'Need for a road' => 'Ремонт дороги',
        'Playground' => 'Детская площадка',
        'Parking' => 'Парковка',
        'school' => 'Школа'
    ];
    
    protected $table = "appeal_citizens";
    protected $primaryKey = "id";
    protected $guarded = false;
    protected $casts = [
        'text_appeal_lem' => 'array'
    ];
    protected $hidden = ["text_appeal_lem", "created_at", "updated_at"];
    // protected $appends = ['type_enum'];

    // public function getTypeEnumAttribute() {
    //     return [
    //         'Необходимость дороги/тротуара'=>'roadNecessary',
    //         'Общее благоустройство'=>'beautification ',
    //         'Капитальный ремонт в доме'=>'generalOverhaul',
    //         'Ремонт дороги'=>'roadRepair',
    //         'Парковка/школа'=>'parkingSchool',
    //         'Детская площадка'=>'playground'
    //     ][$this->type] ?? null;
    // }
}
