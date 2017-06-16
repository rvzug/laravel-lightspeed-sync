<?php

namespace Rvzug\LightspeedSync\Commands;

use Illuminate\Console\Command;
use Rvzug\LightspeedSync\LightspeedSync;

class LightspeedSyncCommand extends Command
{
    protected $signature = 'lightspeedsync:init';

    protected $description = 'Get all resources from Lightspeed Api and save them in Laravel models';

    protected $lightspeedsync;
    protected $arguments = [];

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