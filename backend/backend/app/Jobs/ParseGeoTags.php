<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use App\Services\ParseService;
use Illuminate\Support\Facades\Log;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Contracts\Queue\ShouldBeUnique;

class ParseGeoTags implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    protected $models;
    /**
     * Create a new job instance.
     *
     * @return void
     */

    public function __construct($models)
    {
        $this->models = $models;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Log::debug($this->models);
        foreach($this->models as $model){
            ParseService::parseCoords($model);
        }
        
    }
}
