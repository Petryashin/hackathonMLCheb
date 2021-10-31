<?php

namespace App\Http\Controllers;

use App\Jobs\ParseGeoTags;
use Illuminate\Http\Request;
use App\Models\AppealCitizen;
use App\Models\Cluster;
use App\Services\ParseService;
use Illuminate\Support\Facades\Http;

use function PHPSTORM_META\type;

class TestController extends Controller
{
    
    public function test()
    {
        dump(Cluster::find(10004)->ids_clusters);
        // dd((new FrontendController)->invokeData());
        // $path = public_path('Вторая категоризация.csv');
        // $parser = new ParseService($path);
        // dump($parser::$keys);
        // $parser->parseTypes();
        // $models = AppealCitizen::all()->chunk(20);
        // foreach($models as $model){
            // ParseGeoTags::dispatch($model);
        // }
        // $i = 0;
        // foreach($models as $model){
        //     $i++;
        //     dump($i);
        //     ParseService::parseCoords($model);
        // }
        
        // $adress = "Чебоксары ".$model->adress." " . $model->home;
        // dump($adress);
        // $res = Http::get("https://nominatim.openstreetmap.org/search", [
        //     "q" => $adress, 
        //     'polygon_geojson' => 1,
        //     'format' => 'jsonv2']
        // );
        // dump($res->json());
        // // dump($res->body());
        // dump($res->status());
    }
}
