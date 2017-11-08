<?php

namespace App\Providers;

use App\Services\MatchGenerator;
use App\Services\MatchGeneratorInterface;
use Illuminate\Support\ServiceProvider;

class MatchMapServiceProvider extends ServiceProvider
{
	
	protected $defer = true;
	
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(MatchGeneratorInterface::class, function($app){
        	return new MatchGenerator();
        });
    }
    
    public function provides() {
	    return [MatchGeneratorInterface::class];
    }
}
