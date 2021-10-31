<?php

namespace App\Http\Controllers;

use App\Jobs\ParseGeoTags;
use Illuminate\Http\Request;
use App\Models\AppealCitizen;
use App\Services\ParseService;

class ApiController extends Controller
{
    /**
     * Парсинг данных после preprocessing.ipynb
     */
    public function parse(){
        $relativePath = "Просьбы_жителей_Лемматизация.csv"; // Возможна реализация решения через загрузку в АПИ
        $path = public_path($relativePath); //
        $parser = new ParseService($path);
        $parser->parse();
    }
    /**
     * Запуск парсинга геометок по текстовым данным адресов, выполняется через очередь
     */
    public function parseGeoTags(){
        $models = AppealCitizen::all()->chunk(20);
        foreach($models as $model){
            ParseGeoTags::dispatch($model);
        }
    }
    /**
     * Простановка классов для обращений после предсказания модели ML
     */
    public function parseTypes(){
        $path = public_path('Вторая категоризация.csv'); // // Возможна реализация решения через загрузку в АПИ
        $parser = new ParseService($path);
        $parser->parseTypes();
    }
    public function parseClusters(){
        $path = public_path('Кластеризация.csv'); // // Возможна реализация решения через загрузку в АПИ
        $parser = new ParseService($path);
        $parser->parseClusters();
    }
    public function parseOpenStreetMap(){
        $path = public_path('parseOpenStreetMap.csv'); // // Возможна реализация решения через загрузку в АПИ
        $parser = new ParseService($path);
        $parser->parseOpenStreetMap();
    }
}
