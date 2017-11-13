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
use App\Animal;

class RedisUserMatchService implements UserMatchServiceInterface
{
	private $matchGenerator;
	private $redis1;
	private $redis2;
	
	public function __construct(MatchServiceInterface $matchGenerator)
	{
		$this->matchGenerator = $matchGenerator;
		$this->redis1 = Redis::connection();
		$this->redis2 = Redis::connection('users');
	}
	
	#region MAIN METHODS
	public function saveMatchesForUser() {
		if(Auth::id() !== null){
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
	
	public function takeMatchForUser() {
		$key = "user:".Auth::id();
		$match = $this->redis2->rpop($key);
		$match = unserialize($match);
		//adding current score from DB
		$match['score_0'] = $this->getAnimalScore($match['id_0']);
		$match['score_1'] = $this->getAnimalScore($match['id_1']);
		return $match;
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
		$data = $this->redis2->lrange("user:".Auth::id(),0,1);
		if(count($data)>0){
			return true;
		}else{
			return false;
		}
	}
	
	private function createUserMatches()
	{
		Redis::pipeline(function($pipe){
			//takes general match map
			$matches = $this->matchGenerator->getMatchMap();
			$this->redis2->del("user:".Auth::id());
			// saves general match map to users's own list
			$this->redis2->restore("user:".Auth::id(), 0, $matches);
		});
	}
	
	private function getAnimalScore($animalID)
	{
		$score = Animal::where('id','=',$animalID)
			->get(['score'])->toArray()[0]['score'];
		return $score;
	}
	#endregion
}