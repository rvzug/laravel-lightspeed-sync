<?php

namespace Rvzug\LightspeedSync\Jobs;

use Gunharth\Lightspeed\LightspeedFacade as LightspeedApi;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
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

    public function __construct($resource, $page, $params = ['limit'=> 250], $childresources)
    {
        if(!$resource)
            throw new \Exception("No resource set");

        if(!page)
            throw new \Exception("No page parameter set");

        $this->resource = $resource;
        $this->page = $page;
        $this->params = $params;

        $this->params['page'] = $this->page;
    }

    public function handle(LightspeedSync $lightspeedSync)
    {
        if(!isset($this->params['limit']) || !is_int($this->params['limit']))
            $this->params['limit'] = 250;

        if(!isset($this->params['page']) || !is_int($this->params['page']))
            $this->params['page'] = 250;

        try {
            $this->response = LightspeedApi::{$this->resource}()->get($this->params);
        }
        catch (\WebshopappApiException $e) {
            return $e;
        }

        foreach ($this->response as $item)
            LightspeedSyncFacade::in($this->resource, $item['id'], $item);

        event(new LightspeedSyncGetPageJobReady($this->resource, $this->response, $this->params, $this->get));

    }
}