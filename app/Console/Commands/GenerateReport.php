<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Jobs\MakeReport;

class GenerateReport extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'generate:report {url}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generates a full report for a specific URL';

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
     * @return mixed
     */
    public function handle()
    {
        $url = $this->argument('url');
        $this->info('The report generation has been added to queue ...');
        MakeReport::dispatch($url);
        $this->info('The report has been generated successfully');
    }
}