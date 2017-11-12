<?php

namespace App\Providers;

use App\Services\RedisMatchService;
use App\Services\MatchServiceInterface;
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
        $this->app->bind(MatchServiceInterface::class, function($app){
        	return new RedisMatchService();
        });
    }
    
    public function provides() {
	    return [MatchServiceInterface::class];
    }
}
