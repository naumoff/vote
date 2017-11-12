<?php

namespace App\Providers;

use App\Services\RedisMatchService;
use App\Services\RedisUserMatchService;
use App\Services\UserMatchServiceInterface;
use Illuminate\Support\ServiceProvider;

class UserMatchMapServiceProvider extends ServiceProvider
{
	/**
	 * Indicates if loading of the provider is deferred.
	 * @var bool
	 */
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
		$this->app->bind(UserMatchServiceInterface::class, function($app){
			return new RedisUserMatchService(new RedisMatchService());
		});
	}
	
	public function provides() {
		return [UserMatchServiceInterface::class];
	}
}
