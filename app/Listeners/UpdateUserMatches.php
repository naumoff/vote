<?php

namespace App\Listeners;

use App\Services\RedisUserMatchService;
use App\Services\UserMatchServiceInterface;
use Illuminate\Auth\Events\Registered;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Auth\Events\Login;


class UpdateUserMatches
{
	public $userMatchSaver;
	
    public function __construct(UserMatchServiceInterface $userMatchSaver)
    {
        $this->userMatchSaver = $userMatchSaver;
    }

    public function handle(Login $event)
    {
    	$this->userMatchSaver->saveMatchesForUser();
    	
    }
}
