<?php

namespace App\Providers;

use App\Services\RedisMatchGenerator;
use App\Services\RedisUserMatchSaver;
use App\Services\UserMatchSaverInterface;
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
		$this->app->bind(UserMatchSaverInterface::class, function($app){
			return new RedisUserMatchSaver(new RedisMatchGenerator());
		});
	}
	
	public function provides() {
		return [UserMatchSaverInterface::class];
	}
}
