<?php

namespace App\Console\Commands;

use App\Services\MatchServiceInterface;
use Illuminate\Console\Command;

class GenerateMatches extends Command
{
	private $matches;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'matches:generate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'this command generates matches and save it to Redis';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(MatchServiceInterface $matches)
    {
        parent::__construct();
        
        $this->matches = $matches;
    }

    /**
     * Execute the console command.
     * @return mixed
     */
    public function handle()
    {
        $this->matches->compileMatchMap();
        $this->matches->saveMatchMap();
    }
}
