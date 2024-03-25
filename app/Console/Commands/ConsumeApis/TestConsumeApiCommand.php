<?php

namespace App\Console\Commands\ConsumeApis;

use Illuminate\Console\Command;
use App\Jobs\Test\ConsumeApiServiceJob;

class TestConsumeApiCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'consume:api';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $url = "https://openlibrary.org/authors/OL23919A/works.json";
        $jobToDispatch = ConsumeApiServiceJob::dispatch($url)->onQueue('default');
    }
}
