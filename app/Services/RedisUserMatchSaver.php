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
	private $redis;
	
	public function __construct(MatchGeneratorInterface $matchGenerator)
	{
		$this->loggedUserID = Auth::id();
		$this->matchGenerator = $matchGenerator;
		$this->redis = Redis::connection();
	}
	
	#region MAIN METHODS
	public function saveMatchesForUser() {
		if($this->loggedUserID !== null){
			
			$allMatchesStatus = $this->checkGeneratedMatches();
			if($allMatchesStatus === false){
				$this->createGeneratedMatches();
			}
			
//			$userMatchesStatus = $this->checkUserMatches();
//			dd($userMatchesStatus);
			
			$this->saveUserMatches();
		}
	}
	#endregion
	
	#region SERVICE METHODS
	private function checkGeneratedMatches()
	{
		$data = $this->redis->hgetall('matches:0');
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
	
	}
	
	private function saveUserMatches()
	{
		$matchMap = $this->matchGenerator->getMatchMap();
	}
	#endregion
}