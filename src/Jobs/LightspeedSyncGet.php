<?php

namespace Rvzug\LightspeedSync\Jobs;

use Gunharth\Lightspeed\LightspeedFacade as LightspeedApi;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Rvzug\LightspeedSync\Events\LightspeedSyncGetJobReady;
use Rvzug\LightspeedSync\LightspeedSync;

class LightspeedSyncGet implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $resource;
    protected $id;
    protected $params = [];
    protected $get = false;
    protected $childresources = false;
    protected $response = null;

    public function __construct($resource, $id, $params = [], $childresource = false)
    {
        if(!$resource)
            throw new \Exception("No resource set");

        if(!$resource)
            throw new \Exception("No id set");

        $this->resource = $resource;
        $this->id = $id;
        $this->params = $params;
        $this->childresources = $childresource;
    }

    public function handle(LightspeedSync $lightspeedSync)
    {
        try {
            $this->response = LightspeedApi::{$this->resource}()->get($this->id, $this->params);
        }
        catch (\WebshopappApiException $e) {
            return $e;
        }

        foreach ($this->response as $item)
            LightspeedSyncFacade::in($this->resource, $this->id, $item);

        event(new LightspeedSyncGetJobReady($this->resource, $this->id, $this->response, $this->params, $this->childresources));

    }
}