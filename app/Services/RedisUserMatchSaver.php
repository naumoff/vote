<?php
/**
 * Created by PhpStorm.
 * User: andre
 * Date: 09.11.2017
 * Time: 9:38
 */

namespace App\Services;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redis;

class RedisUserMatchSaver implements UserMatchSaverInterface
{
	private $loggedUserID;
	private $matchGenerator;
	private $redis1;
	private $redis2;
	
	public function __construct(MatchGeneratorInterface $matchGenerator)
	{
		$this->loggedUserID = Auth::id();
		$this->matchGenerator = $matchGenerator;
		$this->redis1 = Redis::connection();
		$this->redis2 = Redis::connection('users');
	}
	
	#region MAIN METHODS
	public function saveMatchesForUser() {
		if($this->loggedUserID !== null){
			$allMatchesStatus = $this->checkGeneratedMatches();
			if($allMatchesStatus === false){
				$this->createGeneratedMatches();
			}
			
			$userMatchesStatus = $this->checkUserMatches();
			if($userMatchesStatus === false){
				$this->createUserMatches();
			}
		}
	}
	#endregion
	
	#region SERVICE METHODS
	private function checkGeneratedMatches()
	{
		$data = $this->redis1->lrange('matches',0,1);
		if(count($data)==0){
			return false;
		}else{
			return true;
		}
	}
	
	private function createGeneratedMatches()
	{
		$this->matchGenerator->compileMatchMap();
		$this->matchGenerator->saveMatchMap();
	}
	
	private function checkUserMatches()
	{
		return false;
	}
	
	private function createUserMatches()
	{
		Redis::pipeline(function($pipe){
			$matches = $this->matchGenerator->getMatchMap();
			$this->redis2->del("user:$this->loggedUserID");
			$this->redis2->restore("user:$this->loggedUserID", 0, $matches);
		});
	}
	#endregion
}