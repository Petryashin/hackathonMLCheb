<?php

namespace App\Services;

use App\Models\Cluster;
use App\Models\AppealCitizen;
use App\Models\OpenStreetMap;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;


class ParseService
{
    public static $keys;
    public function __construct($path)
    {
        $this->file = fopen($path, 'r');

        static::$keys = array_flip(fgetcsv($this->file));
    }
    
    public function parseOpenStreetMap()
    {
        while ($stringArr = fgetcsv($this->file)) {
            $this->fillTableOpenStreetMap($stringArr);
        }
    }

    public function fillTableOpenStreetMap($arr)
    {
        OpenStreetMap::updateOrCreate(
            [
                "id" => $arr[static::$keys["id"]]
            ],
            [
                "lat" => $arr[static::$keys["lat"]],
                "lng" => $arr[static::$keys["lon"]],
                "type" => $arr[static::$keys["type"]]
            ]
        );
    }


    public function parseClusters()
    {
        while ($stringArr = fgetcsv($this->file)) {
            $this->fillTableClusters($stringArr);
        }
    }

    public function fillTableClusters($arr)
    {
        Cluster::updateOrCreate(
            [
                "id" => $arr[static::$keys["id"]]
            ],
            [
                "ids_clusters" => json_decode($arr[static::$keys["ids"]],true),
                "lat" => $arr[static::$keys["lat"]],
                "lng" => $arr[static::$keys["lng"]],
                "type" => $arr[static::$keys["type"]]
            ]
        );
    }

    public function parse()
    {
        while ($stringArr = fgetcsv($this->file)) {
            $this->fillTable($stringArr);
        }
    }

    protected function fillTable($arr)
    {
        AppealCitizen::updateOrCreate(
            [
                "id" => $arr[static::$keys["ids"]]
            ],
            [
                "text_appeal" => $arr[static::$keys["текст обращения"]],
                "adress" => $arr[static::$keys["Адрес обращения"]],
                "text_appeal_lem" => $arr[static::$keys["listTextAppealLem"]],
                "home" => $arr[static::$keys["Дом"]]
            ]
        );
    }

    public function parseTypes()
    {
        while ($stringArr = fgetcsv($this->file)) {
            $this->fillTableTypes($stringArr);
        }
    }
    
    protected function fillTableTypes($arr)
    {
        AppealCitizen::updateOrCreate(
            [
                "id" => $arr[static::$keys["ids"]]
            ],
            [
                "type" => $arr[static::$keys["named_labels"]], // Категории           
            ]
        );
    }

    public static function parseCoords($model)
    {
        if ($model->lat && $model->lng) {
            return;
        }
        $adress = "Чебоксары " . $model->adress . " " . $model->home;
        $res = Http::get(
            "https://nominatim.openstreetmap.org/search",
            [
                "q" => $adress,
                'polygon_geojson' => 1,
                'format' => 'jsonv2'
            ]
        );

        $result =  $res->json()[0] ??  null;
        if (!$result) {
            Log::debug("id,$model->id, address $adress");
        }
        if ($result) {
            $model->lat = $result["lat"];
            $model->lng = $result["lon"];
            $model->save();
        }
        sleep(1);
    }
}
