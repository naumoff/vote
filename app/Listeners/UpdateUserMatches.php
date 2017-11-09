<?php

namespace App\Listeners;

use App\Services\RedisUserMatchSaver;
use App\Services\UserMatchSaverInterface;
use Illuminate\Auth\Events\Registered;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Auth\Events\Login;


class UpdateUserMatches
{
	public $userMatchSaver;
	
    public function __construct(userMatchSaverInterface $userMatchSaver)
    {
        $this->userMatchSaver = $userMatchSaver;
    }

    public function handle(Login $event)
    {
    	$this->userMatchSaver->saveMatchesForUser();
    	
    }
}
