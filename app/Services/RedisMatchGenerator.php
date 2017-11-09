<?php
/**
 * Created by PhpStorm.
 * User: andre
 * Date: 08.11.2017
 * Time: 9:02
 */

namespace App\Services;

use App\Animal;
use Illuminate\Support\Facades\Redis;

class RedisMatchGenerator implements MatchGeneratorInterface {
	
	private $matches;
	
	#region MAIN METHODS
	
	public function compileMatchMap()
	{
		$animals = $this->fetchAnimals();
		$rangedAnimals = $this->rangeAnimals($animals);
		unset($animals);
		$this->matches = $this->makeMatches($rangedAnimals);
		unset($rangedAnimals);
		
		return $this;
	}
	
	public function saveMatchMap()
	{
		$this->saveToRedis();
	}
	
	public function getMatchMap()
	{
		$redis = Redis::connection();
		$data = $redis->dump('matches');
		return $data;
	}
	
	#endregion
	
	#region SERVICE METHODS
	private function fetchAnimals()
	{
		return Animal::fetchAnimals();
	}
	
	private function rangeAnimals($animals)
	{
		$groupQty = (int)floor(count($animals)/3);

		$rangedAnimals = [
			'top'=>[],
			'middle'=>[],
			'low'=>[]
		];
		foreach ($animals AS $key=>$animal){
			if(count($rangedAnimals['top'])<=$groupQty)
			{
				$rangedAnimals['top'][] = [
					'id'=>$animal['id'],
					'type'=>$animal['type'],
					'name'=>$animal['name'],
					'photo'=>$animal['photo']
				];
				continue;
			}
			
			if(count($rangedAnimals['top'])>$groupQty
				&& count($rangedAnimals['middle'])<=$groupQty)
			{
				$rangedAnimals['middle'][] = [
					'id'=>$animal['id'],
					'type'=>$animal['type'],
					'name'=>$animal['name'],
					'photo'=>$animal['photo']
				];
				continue;
			}
			
			if(count($rangedAnimals['middle'])>$groupQty)
			{
				$rangedAnimals['low'][] = [
					'id'=>$animal['id'],
					'type'=>$animal['type'],
					'name'=>$animal['name'],
					'photo'=>$animal['photo']
				];
			}
		}
		return $rangedAnimals;
	}
	
	private function makeMatches($rangedAnimals)
	{
		$top = $rangedAnimals['top'];
		$middle = $rangedAnimals['middle'];
		$low = $rangedAnimals['low'];
		unset($rangedAnimals);
		
		$matches = [];
		
		$iteration = count($top)*3;
		if($iteration > 500){$iteration = 500;}
		
		for($a=0; $a<$iteration; $a++){
			// top - middle
			$matches[] = [$top[rand(0,count($top)-1)], $middle[rand(0,count($middle)-1)]];
			// middle - low
			$matches[] = [$middle[rand(0,count($middle)-1)], $low[rand(0,count($low)-1)]];
			// low - top
			$matches[] = [$low[rand(0,count($low)-1)], $top[rand(0,count($middle)-1)]];
		}
		return $matches;
	}
	
	private function saveToRedis()
	{
		if(count($this->matches) > 0){
			Redis::pipeline(function($pipe) {
				$pipe->flushdb();
				foreach ($this->matches AS $key=>$match) {
					$match = [
						'id_0' => $match[0]['id'],
						'name_0' => $match[0]['name'],
						'type_0' => $match[0]['type'],
						'photo_0' => $match[0]['photo'],
						'id_1' => $match[1]['id'],
						'name_1' => $match[1]['name'],
						'type_1' => $match[1]['type'],
						'photo_1' => $match[1]['photo'],
					];
					$pipe->rpush('matches',serialize($match));
				}
			});
		}

	}
	#endregion
}