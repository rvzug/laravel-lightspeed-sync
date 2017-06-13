<?php

namespace Rvzug\LightspeedSync\Jobs;

use Gunharth\Lightspeed\LightspeedFacade as LightspeedApi;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Rvzug\LightspeedSync\Events\LightspeedSyncCountJobReady;
use Rvzug\LightspeedSync\LightspeedSync;

class LightspeedSyncCount implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $resource;
    protected $params = [];
    protected $get = false;
    protected $childresources = false;
    protected $response = null;

    public function __construct($resource, $params, $get = false, $childresources = false)
    {
        if(!$resource)
            throw new \Exception("No resource set");

        $this->resource = $resource;
        $this->params = $params;
        $this->get = $get;
        $this->childresources = $childresources;
    }

    public function handle(LightspeedSync $lightspeedSync)
    {
        try {
            $this->response = LightspeedApi::{$this->resource}()->count($this->params);
        }
        catch (\WebshopappApiException $e) {
            return $e;
        }

        event(new LightspeedSyncCountJobReady($this->resource, $this->response, $this->params, $this->get, $this->childresources));

    }
}