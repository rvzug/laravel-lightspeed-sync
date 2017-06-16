<?php

namespace Rvzug\LightspeedSync\Jobs;

use Gunharth\Lightspeed\LightspeedFacade as LightspeedApi;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Log;
use Rvzug\LightspeedSync\Events\LightspeedSyncGetJobReady;
use Rvzug\LightspeedSync\LightspeedSync;
use Rvzug\LightspeedSync\LightspeedSyncFacade;

class LightspeedSyncGet implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $resource;
    protected $parentResourceId;
    protected $params = [];
    protected $get = false;
    protected $childresources = false;
    protected $response = null;

    public $tries = 1;
    public $timeout = 60;

    public function __construct($resource, $parentResourceId, $params = [], $childresource = false)
    {
        if(!$resource)
            throw new \Exception("No resource set");

        if(!$parentResourceId)
            throw new \Exception("No id set");

        $this->resource = $resource;
        $this->parentResourceId = $parentResourceId;
        $this->params = $params;
        $this->childresources = $childresource;
    }

    public function handle(LightspeedSync $lightspeedSync)
    {
        try {
            $this->response = LightspeedApi::{$this->resource}()->get($this->parentResourceId, $this->params);

            if ($this->attempts() == 3) {
                Log::debug("release again over 5 minutes");
                $this->release(5 * 60);
            }
        }
        catch (\WebshopappApiException $e) {
            return $e;
        }

        event(new LightspeedSyncGetJobReady($this->resource, $this->parentResourceId, $this->response, $this->params, $this->childresources));

    }

    public function failed(Exception $exception)
    {
        dump($exception);
    }
}