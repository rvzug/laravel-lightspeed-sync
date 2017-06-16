<?php

namespace Rvzug\LightspeedSync\Jobs;

use Gunharth\Lightspeed\LightspeedFacade as LightspeedApi;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Log;
use Rvzug\LightspeedSync\Events\LightspeedSyncCountJobReady;
use Rvzug\LightspeedSync\Events\LightspeedSyncGetPageJobReady;
use Rvzug\LightspeedSync\LightspeedSync;
use Rvzug\LightspeedSync\LightspeedSyncFacade;

class LightspeedSyncGetPage implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $resource;
    protected $params = ['limit'=> 250];
    protected $childresources = false;
    protected $response = null;

    public $tries = 1;
    public $timeout = 60;

    public function __construct($resource, $page, $params = ['limit'=> 250], $childresources)
    {
        if(!$resource)
            throw new \Exception("No resource set");

        if(!$page)
            throw new \Exception("No page parameter set");

        $this->resource = $resource;
        $this->page = $page;
        $this->params = $params;
        $this->childresources = $childresources;

        $this->params['page'] = $this->page;
    }

    public function handle(LightspeedSync $lightspeedSync)
    {
        if(!isset($this->params['limit']) || !is_int($this->params['limit']))
            $this->params['limit'] = 250;

        if(!isset($this->params['page']) || !is_int($this->params['page']))
            $this->params['page'] = 250;

        try {
            $this->response = LightspeedApi::{$this->resource}()->get(null, $this->params);

            if ($this->attempts() == 3) {
                Log::debug("release again over 5 minutes");
                $this->release(5 * 60);
            }
        }
        catch (\WebshopappApiException $e) {
            return $e;
        }

        event(new LightspeedSyncGetPageJobReady($this->resource, $this->response, $this->params, $this->childresources));

    }

    public function failed(Exception $exception)
    {
        dump($exception);
    }
}