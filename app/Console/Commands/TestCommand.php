<?php

namespace App\Console\Commands;

use App\Models\Article;
use Illuminate\Console\Command;
use jericho\LaravelRestfulCodex\Facades\LaravelRestfulCodexFacade;
use jericho\LaravelRestfulCodex\Facades\ModelBuilderFacade;

class TestCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle(): int
    {
        return 0;
    }
}
