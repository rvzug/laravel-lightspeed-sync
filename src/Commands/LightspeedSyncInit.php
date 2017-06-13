<?php

namespace Rvzug\LightspeedSync\Commands;

use Rvzug\LightspeedSync\LightspeedSync;

class LightspeedSyncInit extends Command
{
    protected $signature = 'lyghtspeedsync:init';

    protected $description = 'Get all resources from Lightspeed Api and save them in Laravel models';

    protected $lightspeedsync;

    public function __construct(LightspeedSync $lightspeedSync)
    {
        parent::__construct();

        $this->lightspeedsync = $lightspeedSync;
    }

    public function handle()
    {
        $this->lightspeedsync->init($this->arguments);
    }
}