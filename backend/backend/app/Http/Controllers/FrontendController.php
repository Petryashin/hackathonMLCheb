<?php

namespace App\Http\Controllers;

use App\Models\Cluster;
use Illuminate\Http\Request;
use App\Models\AppealCitizen;
use App\Models\OpenStreetMap;
use Illuminate\Support\Facades\DB;

class FrontendController extends Controller
{
    public function updateCluster(Request $request)
    {
        $data = $request->all();
        $cluster = Cluster::find($data['id']);
        if(!$cluster){
            return ;
        }
        $cluster->comment = $data['text'];
        $cluster->save();
    }
    public function invokeOpenStreetMap(){
        $res = OpenStreetMap::all()->toArray();
        return ["data"=>$res,'keys'=>[
            'leisure'=>'Парки и игровые площадки',
            'parkings'=>'Парковки',
            'school'=>'Школы',
        ]];
    }
    public function invokeClustersKeys(){
        $categories = DB::table("clusters")->pluck('type')
        ->unique()->values()->reject(function ($value){
            return $value === null;
        })
        ->all();
        return $categories;
    }
    public function invokeClusters()
    {
        
        $polygons = $this->invokePolygons();
        $request = [];
        foreach($polygons as $polygon){

            $request[$polygon] = Cluster::where('type',$polygon)->whereNotNull("lat")->get()->toArray();
        }
        return ["data"=>$request, "keys"=>AppealCitizen::KEYS_CATEGORIES];
    }

    public function invokeAppeals(Request $request){
        $cluster_id = $request->all()['cluster_id'];
        $cluster = Cluster::find((int)$cluster_id);
        if (!$cluster){
            return null;
        }
        $idsArr = $cluster->ids_clusters;
        $res = AppealCitizen::whereIn('id',$idsArr)->get()->toArray();
        return $res;
    }

    protected  function invokePolygons(){
        $categories = DB::table("appeal_citizens")->pluck('type')
        ->unique()->values()->reject(function ($value){
            return $value === null;
        })
        ->all();
        return $categories;
    }
    public function invokeData(){
        $polygons = $this->invokePolygons();
        $request = [];
        foreach($polygons as $polygon){

            $request[$polygon] = AppealCitizen::where('type',$polygon)->whereNotNull("lat")->get()->toArray();
        }
        return ["data"=>$request, "keys"=>AppealCitizen::KEYS_CATEGORIES];
    }
    public function invokeDataFilter(Request $request){
        $arrFilter = $request->all();
        $polygons = $this->invokePolygons();
        $request = [];
        foreach($polygons as $polygon){
            if (in_array($polygon,$arrFilter))
            $request[$polygon] = AppealCitizen::where('type',$polygon)->whereNotNull("lat")->get()->toArray();
        }
        return ["data"=>$request, "keys"=>AppealCitizen::KEYS_CATEGORIES];
    }
}
